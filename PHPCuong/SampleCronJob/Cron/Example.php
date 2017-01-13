<?php

/**
 *
 * @Author              Ngo Quang Cuong <bestearnmoney87@gmail.com>
 * @Date                2017-01-14 04:31:58
 * @Last modified by:   nquangcuong
 * @Last Modified time: 2017-01-14 05:02:58
 */

namespace PHPCuong\SampleCronJob\Cron;

/**
 * Class Example
 */
class Example
{

    /**
     * (cron process)
     *
     * @return void
     */
    public function execute()
    {
        $string = 'The cron was run again again.';
        \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface')->debug($string);
    }
}
