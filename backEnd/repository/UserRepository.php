<?php

require_once "../model/User.php";
require_once "BaseRepository.php";

/**
 * User repository class. All database related stuff with user is done here.
 */
class UserRepository extends BaseRepository {

    /**
     * Return the user with the given $email or null if there is no user with this $email.
     */
    function getUserByEmail(string $email): User|null {
        $req = $this->getDb()->prepare("
            SELECT *
            FROM app_user
            LEFT JOIN user_has_role ON app_user.userId = user_has_role.userId
            WHERE userEmail = :userEmail
        ");
        $req->execute(["userEmail" => $email]);

        $rawResult = $req->fetchAll(PDO::FETCH_ASSOC);

        return $this->pdoResultToUser($rawResult);
    }

    /**
     * Save the new user to the database.
     */
    function createUser(User $user): void {
        $this->getDb()->beginTransaction();
        $req = $this->getDb()->prepare("INSERT INTO app_user SET userEmail = :userEmail, userPassword = :userPassword");
        $req->execute([
            "userEmail" => $user->getEmail(),
            "userPassword" => $user->getPassword(),
        ]);

        $userId = $this->getDb()->lastInsertId();

        foreach($user->getRoles() as $role) {
            $req = $this->getDb()->prepare("INSERT INTO user_has_role SET userId=:userId, roleId=:roleId");
            $req->execute([
                "userId" => $userId,
                "roleId" => $role
            ]);
        }
        $this->getDb()->commit();
    }

    /**
     * Convert assoc array PDO result into User business model.
     */
    private function pdoResultToUser(array $pdoResult): User|null {
        if(!$pdoResult) {
            return null;
        }
        $result = $pdoResult[0];
        $roles = [];

        foreach($pdoResult as $row) {
            $roles[] = $row["roleId"];
        }

        return new User($result["userId"], $result["userEmail"], $result["userPassword"], $roles);
    }
}
