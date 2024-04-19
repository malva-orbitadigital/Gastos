<?php
include_once './src/Expenses.php';
include_once './src/Category.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

switch ($action) {
    case 'deleteExpense':
        $id = (int)$_POST['id'] ?? 0;
        echo json_encode(Expenses::deleteExpense($id));
        break;
    case 'deleteCategory':
        $id = (int)$_POST['id'] ?? 0;
        echo json_encode(Category::deleteCategory($id));
        break;
    case 'getTotal':
        echo json_encode(['html' => Expenses::showTotal()]);
        break;
    default:
        echo json_encode(['error' => 'Invalid action']);
}
