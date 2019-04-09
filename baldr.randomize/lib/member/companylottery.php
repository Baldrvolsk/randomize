<?php

namespace Baldr\Randomize\Member;

use Baldr\Randomize\Lottery\LotteryTable;
use Bitrix\Main\Diag\Debug;
use \Bitrix\Main\Entity;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Mail\Event;

class CompanyLotteryTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'randomize_company_lottery';
    }

    public static function getMap()
    {
        return array(
            //ID
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new IntegerField('LOTTERY_ID'),
            new ReferenceField(
                'LOTTERY',
                '\Baldr\Randomize\Lottery\LotteryTable',
                array('=this.LOTTERY_ID' => 'ref.ID')
            ),
            new IntegerField('COMPANY_ID'),
            new ReferenceField(
                'COMPANY',
                '\Baldr\Randomize\Member\CompanyTable',
                array('=this.COMPANY_ID' => 'ref.ID')
            ),

            new IntegerField('DRAW_ALLOWED', array(
                'default' => 0
            )),
            new StringField('REASON', array(
                'validation' => function() {
                    return array(
                        function ($value, $primary, $row, $field) {
                            if ($row["DRAW_ALLOWED"] == 2 && strlen($value) < 1) {
                                return 'Не указана причина отклонения заявки';
                            } else {
                                return true;
                            }
                        }
                    );
                }
            )),
        );
    }

    public static function onAfterUpdate(Entity\Event $event)
    {
        $data = $event->getParameter("fields");
        Debug::dumpToFile($data, 'update company fields');
        $id = $data['ID'];
        Debug::dumpToFile($id, 'update company id');
        $lcd = self::getRowById($id);
        Debug::dumpToFile($lcd, 'company info from id');

        $lottery = LotteryTable::getRowById($lcd["LOTTERY_ID"]);
        $company = CompanyTable::getRowById($lcd["COMPANY_ID"]);
        $member = MemberTable::getRow(array(
            'filter' => array(
                "COMPANY_ID" => $lcd["COMPANY_ID"],
                'ACTIVE_MEMBER' => true
            )
        ));

        if ($data['DRAW_ALLOWED'] == 2) {
            $arFieldsReject = Array(
                'EMAIL_MEMBER' => $member["EMAIL"],
                'REASON' => $lcd["REASON"],
                'FULL_NAME' => $member["FULL_NAME"],
                'PHONE' => $member["PHONE"],
                'COMPANY_NAME' => $company["COMPANY_NAME"],
                'LOTTERY_NAME' => $lottery["TITLE"]
            );
            Event::send(array(
                "EVENT_NAME" => 'OL_REJECT_REG',
                "LID" => "s1",
                "C_FIELDS" => $arFieldsReject
            ));
        } elseif ($data['DRAW_ALLOWED'] == 1) {
            $arFieldsConfirm = Array(
                'EMAIL_MEMBER' => $member["EMAIL"],
                'FULL_NAME' => $member["FULL_NAME"],
                'LOTTERY_NAME' => $lottery["TITLE"],
                'LOTTERY_DATA' => $lottery['TIME_DRAW_START']->format("d-m-Y"), //." - ".$lottery['TIME_DRAW_END']->format("d-m-Y"),
                'LOT_COMP_ID' => $data["ID"]
            );
            Event::send(array(
                "EVENT_NAME" => 'OL_CONFIRM_REG',
                "LID" => "s1",
                "C_FIELDS" => $arFieldsConfirm
            ));
        }
    }
}