<?php

namespace Baldr\Randomize\Member;

use \Bitrix\Main\Entity;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;

class CompanyTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'randomize_company';
    }

    public static function getMap()
    {
        return array(
            //ID
            new IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            //Название
            new StringField('COMPANY_NAME', array(
                'required' => true,
                'unique' => true,
                'validation' => function() {
                    return array(
                        new Entity\Validator\Unique,
                    );
                }
            )),
            //ID уникальной кампании
            new IntegerField('UNIC_ID'),
            //связь один ко многим: компания - сотрудники
            new OneToMany('MEMBERS', MemberTable::class, 'COMPANY')
        );
    }
}