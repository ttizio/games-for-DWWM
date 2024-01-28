
-- Delete existing tables
DROP TABLE IF EXISTS user_has_role;
DROP TABLE IF EXISTS app_user;
DROP TABLE IF EXISTS app_role;

-- Creation de la table utilisateurs
CREATE TABLE app_user
(
    userId INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    userEmail VARCHAR(100) NOT NULL,
    userPassword VARCHAR(255) NOT NULL
);

-- Creation de la table roles
CREATE TABLE app_role
(
    roleId INT PRIMARY KEY NOT NULL,
    roleName VARCHAR(100) NOT NULL
);

-- Insert default app roles
INSERT INTO app_role(roleId, roleName)
VALUES
    (1, 'administrateur'),
    (2, 'stduser');

-- Creation de la table d'association utilisateurs/roles
CREATE TABLE user_has_role
(
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    userId INT NOT NULL,
    roleId INT NOT NULL
);
CREATE UNIQUE INDEX userRoleAssociation on user_has_role(userId, roleId);
ALTER TABLE user_has_role ADD FOREIGN KEY (userId) REFERENCES app_user(userId);
ALTER TABLE user_has_role ADD FOREIGN KEY (roleId) REFERENCES app_role(roleId);
