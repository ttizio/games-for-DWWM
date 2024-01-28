<?php

class User {
    private int|null $id;
    private string $email;
    private string $password;
    private array $roles;

    function __construct(int|null $id, string $email, string $password, array $roles) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->roles = $roles;
    }

    function getId(): int {
        return $this->id;
    }

    function getEmail(): string {
        return $this->email;
    }

    function getPassword(): string {
        return $this->password;
    }

    function getRoles(): array {
        return $this->roles;
    }
}