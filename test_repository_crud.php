<?php

// Importez les classes nécessaires
require_once 'src/Model/Repository/Repository.php';

use App\Model\Repository\Repository;

// Créez une instance de Repository
$repository = new Repository();

// Testez l'opération Create
echo "Testing Create operation...\n";
$newEntity = [
    'name' => 'Test Entity',
    'description' => 'This is a test entity.',
    // Ajoutez d'autres champs nécessaires pour l'entité
];
// Ajoutez l'entité à la base de données
$insertId = $repository->create($newEntity);
echo "Created entity with ID: $insertId\n";

// Testez l'opération Read
echo "Testing Read operation...\n";
// Récupérez l'entité que vous venez de créer
$entity = $repository->find($insertId);
echo "Read entity: " . json_encode($entity) . "\n";

// Testez l'opération Update
echo "Testing Update operation...\n";
// Mettez à jour l'entité
$updateData = [
    'name' => 'Updated Test Entity',
    'description' => 'This is an updated test entity.',
    // Ajoutez d'autres champs à mettre à jour
];
$repository->update($insertId, $updateData);
echo "Updated entity with ID: $insertId\n";

// Testez l'opération Read après la mise à jour
echo "Testing Read after Update operation...\n";
$updatedEntity = $repository->find($insertId);
echo "Read updated entity: " . json_encode($updatedEntity) . "\n";

// Testez l'opération Delete
echo "Testing Delete operation...\n";
// Supprimez l'entité
$repository->delete($insertId);
echo "Deleted entity with ID: $insertId\n";

// Testez l'opération Read après la suppression
echo "Testing Read after Delete operation...\n";
$deletedEntity = $repository->find($insertId);
echo "Read deleted entity: " . json_encode($deletedEntity) . "\n";
if (!$deletedEntity) {
    echo "Entity has been successfully deleted.\n";
} else {
    echo "Failed to delete entity.\n";
}
