<?php

require_once "../repository/UserRepository.php";
require_once "BaseService.php";

/**
 * User repository class. All business related stuff with user is done here.
 */
class UserService extends BaseService {

    /**
     * Instance of the UserRepository
     */
    private UserRepository $userRepository;

    function __construct() {
        $this->userRepository = new UserRepository();
    }

    /**
     * Try to login the user with the given $email and $password.
     */
    function login(string $email, string $password): void {
        if(empty($email) || empty($password)) {
            $this->fatalError("There is no email or password in the request");
        }

        $userInDb = $this->userRepository->getUserByEmail($email);

        if($userInDb === null) {
            $this->fatalError("There is no user with this email in db");
        }

        if(!$this->isUserAdmin($userInDb) && !$this->isUserStandardUser($userInDb)) {
            $this->fatalError("User is not authorize to login");
        }

        if($userInDb->getPassword() !== $password) {
            $this->fatalError("Password incorrect");
        }

        session_start();

        // TODO: manage login (token ? php session ?)
    }

    /**
     * Register the user if the request is valid.
     */
    function register(string $email, string $password, string $confirmPassword): void {
        if(empty($email) || empty($password) || empty($confirmPassword)) {
            $this->fatalError("There is no email or password or confirmPasswod in the request");
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->fatalError("The email is not valid");
        }

        $existingUser = $this->userRepository->getUserByEmail($email);

        if($existingUser !== null) {
            $this->fatalError("This email already exists in the Db");
        }

        if($password != $confirmPassword) {
            $this->fatalError("The password and confirmation password are not the same");
        }

        $user = new User(null, $email, $password, [2]);
        $this->userRepository->createUser($user);
    }

    /**
     * Return true if the given user is admin.
     */
    private function isUserAdmin(User $user): bool {
        return $this->userHasRole($user, 1);
    }

    /**
     * Return true if the given user is a standard user.
     */
    private function isUserStandardUser(User $user): bool {
        return $this->userHasRole($user, 2);
    }

    /**
     * Return true if the fiven user has the given role.
     */
    private function userHasRole(User $user, int $expectedRoleId): bool {
        if(in_array($expectedRoleId, $user->getRoles())) {
            return true;
        }

        return false;
    }

}
