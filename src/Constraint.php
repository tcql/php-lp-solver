<?php namespace Tchannel\LpSolver;

use Illuminate\Support\Collection;
use Exception;

class Constraint
{
    const GREATER = 'GE';
    const LESS = 'LE';
    const EQUAL = 'EQ';

    protected $coefficients;
    protected $comparison;
    protected $rhs;
    protected $for;
    protected $name;

    public function __construct(array $coefficients, $comparison, $rhs, $for = null, $name = null)
    {
        $this->coefficients = $coefficients;

        $this->setComparison($comparison);
        $this->rhs = $rhs;
        $this->for = $for;
        $this->name = $name;
    }

    public function setComparison($comparison)
    {
        if (!in_array($comparison, [static::GREATER, static::LESS, static::EQUAL])) {
            throw new Exception("Invalid Comparison type: {$comparison}");
        }

        $this->comparison = $comparison;
        return $this;
    }


    public function getCoefficients()
    {
        return $this->coefficients;
    }

    public function getComparison()
    {
        return $this->comparison;
    }

    public function getRhs()
    {
        return $this->rhs;
    }

    public function setRhs($rhs)
    {
        $this->rhs = $rhs;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFor()
    {
        return $this->for;
    }

    public function setOwner(Collection $owner)
    {
        $this->owner = $owner;
    }

    public function remove()
    {
        if ($this->owner) {
            $key = $this->owner->search($this);
            if (!is_null($key)) {
                $this->owner->forget($key);
            }
            return $this->owner;
        }
    }
}
