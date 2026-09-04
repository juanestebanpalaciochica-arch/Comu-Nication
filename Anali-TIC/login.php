<?php
header('Content-Type: application/json');
require_once 'config.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método HTTP no permitido. Se requiere POST.');
    }

    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('JSON enviado inválido.');
    }

    $email = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $input['password'] ?? '';

    if (!$email || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Credenciales incompletas o formato de email inválido']);
        exit();
    }

    // Consulta con Sentencia Preparada (Anti SQL Injection)
    $stmt = $pdo->prepare('SELECT id, nombre, email, password_hash, departamento, torre FROM usuarios WHERE email = :email AND estado = "Activo"');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];

        echo json_encode([
            'success' => true,
            'user' => [
                'nombre' => $user['nombre'],
                'departamento' => $user['departamento'],
                'torre' => $user['torre']
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado o contraseña incorrecta']);
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error_type' => 'SERVER_ERROR',
        'message' => $e->getMessage()
    ]);
}