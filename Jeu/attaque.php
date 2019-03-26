<?php
require __DIR__.'/header.php';

if (isset($_SESSION['id'])) {

    $characterRepository = new CharacterRepository($base);
    $myCharacter = $characterRepository->find($_SESSION['id']);
    $enemy = $characterRepository->find($_GET['id']);

    
}


?>




<?php



    if ($enemy->getState() === Character::DEAD) {
          echo "Vous venez de découvrir un corp sans vie ...";
      } else {
          if ($myCharacter->getAp() >= Character::ATTAQUE_COST) {

              // Point d'action
              $myCharacter->setAp($myCharacter->getAp() - Character::ATTAQUE_COST);
              $characterRepository->updateAp($myCharacter);

              // Attaque
              $damage = rand(1,100);
              $hp = $enemy->getHp() - $damage;
              $enemy->setHp($hp);
              $characterRepository->updateHp($enemy);

              echo $myCharacter->getName() . " entre dans l'octogone face à ". $enemy->getName()."<br>";

              echo $myCharacter->getName() . " attaque ". $enemy->getName(). " et lui inflige " . $damage ." de dommage <br>";
              if ($enemy->getState() === Character::DEAD) {
                  echo $enemy->getName(). " est mort";
              }
          } else {
              echo "Vous n'avez pas assez de point d'action";
          }
      }require __DIR__.'/footer.php';

      ?>
