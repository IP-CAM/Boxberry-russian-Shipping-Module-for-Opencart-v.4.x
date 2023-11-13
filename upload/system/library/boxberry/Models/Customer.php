<?php
/**
 *
 *  * This file is part of Boxberry Api.
 *  *
 *  * (c) 2016, T. I. R. Ltd.
 *  * Evgeniy Mosunov, Alexander Borovikov
 *  *
 *  * For the full copyright and license information, please view LICENSE
 *  * file that was distributed with this source code
 *  *
 *  * File: Customer.php
 *  * Created: 26.07.2016
 *  *
 */

namespace Boxberry\Models;

/**
 * Class Customer
 * @package Boxberry\Models
 *
 * @var array  $propNameMap
 * @var string $fio
 * @var string $phone
 * @var string $phone2
 * @var string $email
 * @var string $name
 * @var string $address
 * @var string $inn
 * @var string $kpp
 * @var string $rS
 * @var string $korS
 * @var string $bik
 */
class Customer extends AbstractModel
{
    protected array $propNameMap = array(
        'fio'     => 'fio',
        'phone'   => 'phone',
        'phone2'  => 'phone2',
        'email'   => 'email',
        'name'    => 'name',
        'address' => 'address',
        'inn '    => 'inn',
        'kpp'     => 'kpp',
        'r_s'     => 'rS',
        'bank'    => 'bank',
        'kor_s'   => 'korS',
        'bik'     => 'bik'
    );
    protected string $fio     = '';
    protected string $phone   = '';
    protected string $phone2  = '';
    protected string $email   = '';
    protected string $name    = '';
    protected string $address = '';
    protected string $inn     = '';
    protected string $kpp     = '';
    protected string $rS      = '';
    protected string $bank    = '';
    protected string $korS    = '';
    protected string $bik     = '';

    /**
     * @return string
     */
    public function getFio(): string
    {
        return $this->fio;
    }

    /**
     * @param string $fio
     */
    public function setFio(string $fio): void
    {
        $this->fio = $fio;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getPhone2(): string
    {
        return $this->phone2;
    }

    /**
     * @param string $phone2
     */
    public function setPhone2(string $phone2): void
    {
        $this->phone2 = $phone2;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getInn(): string
    {
        return $this->inn;
    }

    /**
     * @param string $inn
     */
    public function setInn(string $inn): void
    {
        $this->inn = $inn;
    }

    /**
     * @return string
     */
    public function getKpp(): string
    {
        return $this->kpp;
    }

    /**
     * @param string $kpp
     */
    public function setKpp(string $kpp): void
    {
        $this->kpp = $kpp;
    }

    /**
     * @return string
     */
    public function getRS(): string
    {
        return $this->rS;
    }

    /**
     * @param string $rS
     */
    public function setRS(string $rS): void
    {
        $this->rS = $rS;
    }

    /**
     * @return string
     */
    public function getBank(): string
    {
        return $this->bank;
    }

    /**
     * @param string $bank
     */
    public function setBank(string $bank): void
    {
        $this->bank = $bank;
    }

    /**
     * @return string
     */
    public function getKorS(): string
    {
        return $this->korS;
    }

    /**
     * @param string $korS
     */
    public function setKorS(string $korS): void
    {
        $this->korS = $korS;
    }

    /**
     * @return string
     */
    public function getBik(): string
    {
        return $this->bik;
    }

    /**
     * @param string $bik
     */
    public function setBik(string $bik): void
    {
        $this->bik = $bik;
    }
}