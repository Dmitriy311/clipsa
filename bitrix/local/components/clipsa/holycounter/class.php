<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
\Bitrix\Main\Loader::includeModule('iblock');
class HolyCounterComponent extends CBitrixComponent  implements \Bitrix\Main\Engine\Contract\Controllerable
{
    public $holyArray = [];
    public function configureActions()
    {
        return [];
    }
    public function onPrepareComponentParams($arParams)
    {
        $holidays = \Bitrix\Iblock\ElementTable::getList(array(
            'select' => array('ID'),
        ))->fetchAll();

        foreach($holidays as $k => $v){
            $a = CIBlockElement::GetProperty(
                '1',
                $v['ID']
            );
            while ($b = $a->GetNext()) {
                $holyArray[] = $b['VALUE'];
            }
        }

        $this->holyArray = $holyArray;

        return $this->arParams;
    }

    public function HolyCounterAction($start_date, $increment)
    {

        $workingDays = [1, 2, 3, 4, 5];
        $holidayDays = $this->holyArray;

        $datePointer = new DateTime($start_date);

        $i = 0;
        $daysChecked = 0;

        while ($i < $increment) {
            $datePointer->modify('+1 day');
            if (in_array($datePointer->format('N'), $workingDays)) {
                if (!in_array($datePointer->format('d.m.Y'), $holidayDays)) {
                    $i++;
                }
            }
        }

        return $datePointer->format('d.m.Y');
    }

    public function executeComponent()
    {
        $this->includeComponentTemplate();
        return $this->arResult;
    }
}