<?php


namespace Baldr\Randomize\Member;

use \Bitrix\Main\Entity;
use \Bitrix\Main\Type;

class MemberTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'randomize_member';
    }

    public static function getMap()
    {
        return array(
            //ID
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            //ID компании
            new Entity\IntegerField('COMPANY_ID'),

            new Entity\ReferenceField(
                'COMPANY',
                '\Baldr\Randomize\Member\CompanyTable',
                array('=this.COMPANY_ID' => 'ref.ID')
            ),
            //ФИО
            new Entity\StringField('FULL_NAME', array(
                'required' => true,
            )),
            //E-mail
            new Entity\StringField('EMAIL', array(
                'required' => true,
                'unique' => true,
                'validation' => function() {
                    return array(
                        new Entity\Validator\Unique,
                    );
                }
            )),
            //телефон
            new Entity\StringField('PHONE', array(
                'required' => true,
            )),
            new Entity\BooleanField("ACTIVE_MEMBER", array(
                'required' => true,
                'default_value' => false
            ))
        );
    }
}