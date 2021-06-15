
------------------------------
-- Archivo de base de datos --
------------------------------
DROP TABLE IF EXISTS users CASCADE;

CREATE TABLE users
(
    id         bigserial     PRIMARY KEY
  , is_deleted boolean       NOT NULL DEFAULT false
);

DROP TABLE IF EXISTS portrait CASCADE;

CREATE TABLE portrait
(
    id             bigserial     PRIMARY KEY REFERENCES users (id) 
  , is_admin       boolean       NOT NULL DEFAULT false
  , nickname       varchar(255)  NOT NULL UNIQUE
  , password       varchar(255)  NOT NULL
  , date_register  timestamp     NOT NULL DEFAULT current_timestamp
  , email          varchar(255)  NOT NULL UNIQUE
  , repository     varchar(255)  NOT NULL UNIQUE
  , prestige_port  varchar(255)  NOT NULL DEFAULT 'Initiate'
  , sex            varchar(255)  NOT NULL 
  , token_pass     varchar(255)  UNIQUE
);

DROP TABLE IF EXISTS type_prestige CASCADE;

CREATE TABLE type_prestige
(
    id              bigserial    PRIMARY KEY
  , prestige        varchar(255) NOT NULL
  , score           smallint     NOT NULL
);

DROP TABLE IF EXISTS prestige CASCADE;

CREATE TABLE prestige
(
    id                bigserial    PRIMARY KEY
  , title             varchar(255) NOT NULL DEFAULT 'Initiate'
  , antiquity         timestamp    
  , puntuation        smallint     NOT NULL DEFAULT 0
  , type_prestige_id  bigint       REFERENCES type_prestige (id) ON DELETE CASCADE
  , users_id          bigint       REFERENCES users (id) ON DELETE CASCADE
);


DROP TABLE IF EXISTS query CASCADE;

CREATE TABLE query
(
    id              bigserial    PRIMARY KEY
  , title           varchar(255) NOT NULL
  , explanation     text         NOT NULL
  , date_created    timestamp    NOT NULL DEFAULT current_timestamp
  , users_id        bigint       REFERENCES users (id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS likes CASCADE;

CREATE TABLE likes
(
    id              bigserial    PRIMARY KEY
  , nickname        varchar(255) NOT NULL
  , answer_id       bigint       REFERENCES answer (id) ON DELETE CASCADE
  , users_id        bigint       REFERENCES users (id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS dislikes CASCADE;

CREATE TABLE dislikes
(
    id              bigserial    PRIMARY KEY
  , nickname        varchar(255) NOT NULL
  , answer_id       bigint       REFERENCES answer (id) ON DELETE CASCADE
  , users_id        bigint       REFERENCES users (id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS answer CASCADE;

CREATE TABLE answer
(
    id              bigserial    PRIMARY KEY
  , content         varchar(255) NOT NULL
  , date_created    timestamp    NOT NULL DEFAULT current_timestamp
  , likes           integer      NOT NULL DEFAULT 0
  , dislikes        integer      NOT NULL DEFAULT 0
  , query_id        bigint       NOT NULL REFERENCES query (id) ON DELETE CASCADE
  , users_id        bigint       REFERENCES users (id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS reminder CASCADE;

CREATE TABLE reminder
(
    id              bigserial    PRIMARY KEY
  , title           varchar(255) NOT NULL
  , dispatch        varchar(255) NOT NULL
  , date_created    timestamp    NOT NULL DEFAULT current_timestamp
  , is_read         boolean      NOT NULL DEFAULT false
  , users_id        bigint       NOT NULL REFERENCES users (id)
);

DROP TABLE IF EXISTS votes CASCADE;

CREATE TABLE votes
(
    id              bigserial    PRIMARY KEY
  , typ             varchar(255) NOT NULL
  , puntuation      integer      NOT NULL
  , suggesting      varchar(255)
  , users_id        bigint       NOT NULL REFERENCES users (id)
);

DROP TABLE IF EXISTS assessment CASCADE;

CREATE TABLE assessment
(
    id              bigserial    PRIMARY KEY
  , total_percent   decimal      NOT NULL DEFAULT 0.0
  , votes_id        bigint       NOT NULL REFERENCES votes (id)
);
--- Fixtures ---

INSERT INTO users (is_deleted)
VALUES (false);

INSERT INTO users (is_deleted)
VALUES (false);

INSERT INTO users (is_deleted)
VALUES (false);

--- Usuario administrador ---

INSERT INTO portrait (is_admin, nickname, password, date_register, email, repository, prestige_port, sex)
VALUES (true, 'admin', crypt('admin', gen_salt('bf', 10)), '2021-04-12 19:10:00', 'jose@gmail.com', 'https://github.com/joseckk', 'Initiate', 'Men');

--- Usuarios normales ---

INSERT INTO portrait (is_admin, nickname, password, date_register, email, repository, prestige_port, sex)
VALUES (false, 'jose', crypt('jose', gen_salt('bf', 10)), '2021-05-12 20:30:00', 'josemanue@gmail.com', 'https://github.com/josemanue', 'Regular', 'Men');

INSERT INTO portrait (is_admin, nickname, password, date_register, email, repository, prestige_port, sex)
VALUES (false, 'javi', crypt('javi', gen_salt('bf', 10)), '2021-06-12 22:10:00', 'javier@gmail.com', 'https://github.com/javier', 'Junior', 'Men');

--- Tipos de prestigio ---
INSERT INTO type_prestige (prestige, score)
VALUES ('Initiate', 0),
       ('Regular', 32),
       ('Junior', 89),
       ('Senior', 150),
       ('Programmer', 300);

INSERT INTO prestige (title, antiquity, puntuation, type_prestige_id, users_id)
VALUES ('Initiate', NULL, 0, 1, 1);

INSERT INTO prestige (title, antiquity, puntuation, type_prestige_id, users_id)
VALUES ('Regular', NULL, 88, 2, 2);

INSERT INTO prestige (title, antiquity, puntuation, type_prestige_id, users_id)
VALUES ('Junior', NULL, 149, 3, 3);