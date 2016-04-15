<?php
/**
 * 2007-2016 [PagSeguro Internet Ltda.]
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author    PagSeguro Internet Ltda.
 * @copyright 2007-2016 PagSeguro Internet Ltda.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 *
 */

namespace PagSeguro\Resources\Factory\Request;

use PagSeguro\Domains\Document;
use PagSeguro\Domains\Phone;
use PagSeguro\Enum\Properties\Current;

/**
 * Class Shipping
 * @package PagSeguro\Resources\Factory\Request
 */
class Sender
{

    private $sender;

    public function __construct()
    {
        $this->sender = new \PagSeguro\Domains\Sender();
    }

    /**
     * @param Address $address
     * @return \PagSeguro\Domains\Shipping
     */
    public function instance(\PagSeguro\Domains\Sender $sender)
    {
        return $sender;
    }

    /**
     * @param $array
     * @return \PagSeguro\Domains\Shipping
     */
    public function withArray($array)
    {
        $properties = new Current;

        $sender = new \PagSeguro\Domains\Sender;
        $phone = new Phone;
        $phone->setAreaCode($array[$properties::SENDER_PHONE_AREA_CODE])
            ->setNumber($array[$properties::SENDER_PHONE_NUMBER]);
        $document = new Document();
        $document->setType($array['documentType'])
            ->setIdentifier($array['documentValue']);

        return $sender->setName($array[$properties::SENDER_NAME])
            ->setEmail($array[$properties::SENDER_EMAIL])
            ->setPhone($phone)
            ->setDocuments($document);
    }

    public function withParameters(
        $name,
        $email,
        $areaCode,
        $number,
        $documentType,
        $documentValue
    ){
        $phone = new Phone;
        $phone->setAreaCode($areaCode)
              ->setNumber($number);

        $document = new Document();
        $document->setType($documentType)
                 ->setIdentifier($documentValue);

        $this->sender->setName($name)
               ->setEmail($email)
               ->setPhone($phone)
               ->setDocuments($document);
        return $this->sender;
    }
}