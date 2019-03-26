<?php
class Character
{

  public const ALIVE = 'alive';
 public const DEAD = 'dead';
 public const ATTAQUE_COST = 5;
 public const AP_REGEN = 60;
    public const AP_MAX = 20;

    private $id;

    private $name;

    private $hp;

    private $ap;

    private $password;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

     public function setName($name)
    {
        $this->name = $name;
    }

    public function getHp()
    {
        return $this->hp;
    }

    public function setHp($hp)
    {
        $this->hp = $hp;
    }

    public function getAp()
    {
        return $this->ap;
    }

    public function setAp($ap)
    {
        $this->ap = $ap;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }






public function hydrate(array $donnees)
   {
       foreach ($donnees as $key => $value)
       {
           $method = 'set'.ucfirst($key);

           if (method_exists($this, $method))
           {
               $this->$method($value);
           }
       }
   }



   public function __construct(array $arrayOfValues = null)
   {
       if ($arrayOfValues !== null) {
           $this->hydrate($arrayOfValues);
       }
   }

   public function getState()
   {
       if ($this->hp < 0) {
           return self::DEAD;
       }
       return self::ALIVE;
   }

   public function getNewAp()
    {
        $datetime1 = new DateTime('now');
        $datetime2 = new DateTime($this->lastaction);
        $interval = $datetime1->diff($datetime2);
        $seconde = $interval->s + $interval->i * 60 + $interval->h * 60 * 60;
        if ($seconde > self::AP_REGEN) {
            $newAP = floor($seconde / self::AP_REGEN);
            $this->ap = $this->ap + $newAP;
        }
    }


    public function updateLastActionAndAp(Character $character)
    {
        $datenow = new DateTime('now');
        $response = $this->base->prepare('UPDATE characters SET lastaction = :lastaction, ap = :ap WHERE id = :id');
        $response->bindValue(':lastaction', $datenow->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $response->bindValue(':ap', $character->getAp(), PDO::PARAM_INT);
        $response->bindValue(':id', $character->getId(), PDO::PARAM_INT);

        $response->execute();
    }
}
