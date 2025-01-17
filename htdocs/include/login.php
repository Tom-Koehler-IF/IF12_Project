<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

enum UserRole : string {
    case Admin = "admin";
    case User = "user";
    case Guest = "guest";
}

enum PermissionAction : string {
    case Allow = "allow";
    case Deny = "deny";
    case Login = "login";
    case Redirect = "redirect";
}

$permissions = [
    UserRole::Admin->value => [
        "/admin" => PermissionAction::Allow,
        "/logout.php" => PermissionAction::Allow,
        "/index.php" => PermissionAction::Redirect,
        "*" => PermissionAction::Deny 
    ],
    UserRole::User->value => [
        "/customer" => PermissionAction::Allow,
        "/logout.php" => PermissionAction::Allow,
        "/index.php" => PermissionAction::Redirect,
        "*" => PermissionAction::Deny
    ],
    UserRole::Guest->value => [
        "/customer/contest.php" => PermissionAction::Login,
        "/customer" => PermissionAction::Allow,
        "/admin" => PermissionAction::Login,
        "/index.php" => PermissionAction::Allow,
        "*" => PermissionAction::Deny
    ]
];

define('SESSION_ACCOUNT', 'ACCOUNT');

/**
* An account that can be logged in.
*/
class Account {
    public readonly int $account_id;
    public readonly string $name;
    public readonly bool $is_admin;

    public function __construct(int $account_id, string $name, bool $is_admin) {
        $this->account_id = $account_id;
        $this->name = $name;
        $this->is_admin = $is_admin;
    }
}

/**
* Tries to login an account with username and password.
* Throws an exception if login fails.
* If login is successfuly sets the ACCOUNT variable in the session
*/
function login(string $username, string $password) {
    if ($username == "admin" && $password == "pwd") {
        $_SESSION[SESSION_ACCOUNT] = new Account(1, $username, true);
    } else if ($username == "user" && $password == "pwd") {
        $_SESSION[SESSION_ACCOUNT] = new Account(2, $username, false);
    } else {
        throw new Exception('Invalid username or password');
    }
}

/**
* Unsets the logged in account. Ignores if it is currently set
*/
function logout() {
    unset($_SESSION[SESSION_ACCOUNT]);
}

function getUserRole(): UserRole {
    if (array_key_exists(SESSION_ACCOUNT, $_SESSION) && $account = $_SESSION[SESSION_ACCOUNT]) {
        if ($account->is_admin) return UserRole::Admin;
        else return UserRole::User;
    } else return UserRole::Guest;
}

function performPermissionAction(PermissionAction $action) {
    switch ($action) {
    case PermissionAction::Deny:
        echo "denied";
        die();
        break;
    case PermissionAction::Login:
        echo "login";
        die();
        break;
    case PermissionAction::Allow:
    case PermissionAction::Redirect:
        break;
    }
}

// Check permissions for webpage
// We get the longest matching path of the permissions array for our user role
$userRole = getUserRole();
$path = $_SERVER['PHP_SELF'];
$permissionPaths = $permissions[$userRole->value];

foreach ($permissionPaths as $subPath => $action) {
    if (str_starts_with($path, $subPath) || $subPath == "*") {
        performPermissionAction($action);
        break;
    }
}

?>
