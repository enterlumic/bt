DROP PROCEDURE IF EXISTS `sp_delete_users`;
DELIMITER ;;
    CREATE PROCEDURE `sp_delete_users`(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
        MODIFIES SQL DATA
    BEGIN

        UPDATE users  SET active= 0
        WHERE id= v_id;
        SET v_i_internal_status:= ROW_COUNT();
    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_get_users`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_users`( b_filtro_like bool
                                                ,vc_string_filtro varchar(100)
                                                ,i_limit_init int
                                                ,i_limit_end int
                                                ,i_colum_order int
                                                ,vc_order_direct varchar(20)
                                                ,OUT v_registro_total BIGINT(20)
                                              )
        READS SQL DATA DETERMINISTIC
        BEGIN
            DECLARE vc_column_order VARCHAR(100);

            SET vc_column_order=CASE 
                                WHEN i_colum_order=0 THEN CONCAT("  ORDER BY id ",vc_order_direct)
                                WHEN i_colum_order=1 THEN CONCAT("  ORDER BY name ",vc_order_direct)
                                WHEN i_colum_order=2 THEN CONCAT("  ORDER BY apellido ",vc_order_direct)
                                WHEN i_colum_order=3 THEN CONCAT("  ORDER BY email ",vc_order_direct)
                                WHEN i_colum_order=4 THEN CONCAT("  ORDER BY email_verified_at ",vc_order_direct)
                                WHEN i_colum_order=5 THEN CONCAT("  ORDER BY password ",vc_order_direct)
                                WHEN i_colum_order=6 THEN CONCAT("  ORDER BY pass_crypt ",vc_order_direct)
                                WHEN i_colum_order=7 THEN CONCAT("  ORDER BY referido ",vc_order_direct)
                                WHEN i_colum_order=8 THEN CONCAT("  ORDER BY myrefcode ",vc_order_direct)
                                WHEN i_colum_order=9 THEN CONCAT("  ORDER BY admin ",vc_order_direct)
                                WHEN i_colum_order=10 THEN CONCAT(" ORDER BY telefono ",vc_order_direct)
                                ELSE ""
            END;

            SET @_QUERY:=CONCAT("SELECT   id AS id
                                        , name
                                        , apellido
                                        , email
                                        , email_verified_at
                                        , password
                                        , pass_crypt
                                        , referido
                                        , myrefcode
                                        , admin
                                        , telefono
                                    FROM users 
                                    WHERE users.active > 0 "
            );

            IF(b_filtro_like=true) THEN BEGIN

                SET @_QUERY:=CONCAT(@_QUERY, " AND (name LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  apellido LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  email LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  email_verified_at LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  password LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  pass_crypt LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  referido LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  myrefcode LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  admin LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  telefono LIKE '%",TRIM(vc_string_filtro),"%')");

            END; END IF;

            IF(i_colum_order IS NOT NULL) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
            END; END IF;

            IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
            END; END IF;

            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

            SELECT COUNT(*) INTO v_registro_total FROM users WHERE active > 0;
        END ;;
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_get_users_by_id`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_users_by_id`(IN `v_id` BIGINT(20))
      READS SQL DATA DETERMINISTIC
      BEGIN
          SELECT id AS id
          , name
          , apellido
          , email
          , email_verified_at
          , password 
          , pass_crypt 
          , referido 
          , myrefcode 
          , admin 
          , telefono 
          , empresa 
          , remember_token 
          , active 
          , created_at 
          , updated_at 
          , usuario_legacy 
          , medio_de_contacto 
          FROM users
          WHERE id= v_id AND active > 0
          LIMIT 1 ;  
      END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_set_users`;
DELIMITER ;;
CREATE PROCEDURE `sp_set_users`(
    IN `v_name` VARCHAR(200)
  , IN `v_apellido` VARCHAR(210)
  , IN `v_email` VARCHAR(220)
  , IN `v_email_verified_at` VARCHAR(230)
  , IN `v_password` VARCHAR(240)
  , IN `v_pass_crypt` VARCHAR(250)
  , IN `v_referido` VARCHAR(260)
  , IN `v_myrefcode` VARCHAR(270)
  , IN `v_admin` VARCHAR(280)
  , IN `v_telefono` VARCHAR(290)
  , IN `v_empresa` VARCHAR(300)
  , IN `v_remember_token` VARCHAR(310)
  , IN `v_active` VARCHAR(320)
  , IN `v_created_at` VARCHAR(330)
  , IN `v_updated_at` VARCHAR(340)
  , IN `v_usuario_legacy` VARCHAR(350)
  , IN `v_medio_de_contacto` VARCHAR(360)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
        BEGIN

            DECLARE v_b_exists INTEGER(1) ;

            SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

            INSERT INTO users(  
              name
              , apellido
              , email
              , email_verified_at
              , password
              , pass_crypt
              , referido
              , myrefcode
              , admin
              , telefono
              , empresa
              , remember_token
              , active
              , created_at
              , updated_at
              , usuario_legacy
              , medio_de_contacto
            )
            SELECT  v_name
            , v_apellido
            , v_email
            , v_email_verified_at
            , v_password
            , v_pass_crypt
            , v_referido
            , v_myrefcode
            , v_admin
            , v_telefono
            , v_empresa
            , v_remember_token
            , v_active
            , v_created_at
            , v_updated_at
            , v_usuario_legacy
            , v_medio_de_contacto

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_importar_users`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_importar_users`(IN `v_id` BIGINT(20)
  , IN `v_name` VARCHAR(200)
  , IN `v_apellido` VARCHAR(210)
  , IN `v_email` VARCHAR(220)
  , IN `v_email_verified_at` VARCHAR(230)
  , IN `v_password` VARCHAR(240)
  , IN `v_pass_crypt` VARCHAR(250)
  , IN `v_referido` VARCHAR(260)
  , IN `v_myrefcode` VARCHAR(270)
  , IN `v_admin` VARCHAR(280)
  , IN `v_telefono` VARCHAR(290)
  , IN `v_empresa` VARCHAR(300)
  , IN `v_remember_token` VARCHAR(310)
  , IN `v_active` VARCHAR(320)
  , IN `v_created_at` VARCHAR(330)
  , IN `v_updated_at` VARCHAR(340)
  , IN `v_usuario_legacy` VARCHAR(350)
  , IN `v_medio_de_contacto` VARCHAR(360)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
    BEGIN

        DECLARE v_b_exists INTEGER(1) ;

        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        SELECT COUNT(*) INTO v_b_exists 
        FROM users 
        WHERE id= v_id AND active > 0 LIMIT 1 ;

        IF (v_b_exists > 0) THEN BEGIN
            UPDATE users 
            SET name   = v_name
              , apellido   = v_apellido
              , email   = v_email
              , email_verified_at   = v_email_verified_at
              , password   = v_password
              , pass_crypt   = v_pass_crypt
              , referido   = v_referido
              , myrefcode   = v_myrefcode
              , admin   = v_admin
              , telefono   = v_telefono
              , empresa   = v_empresa
              , remember_token   = v_remember_token
              , active   = v_active
              , created_at   = v_created_at
              , updated_at   = v_updated_at
              , usuario_legacy   = v_usuario_legacy
              , medio_de_contacto   = v_medio_de_contacto
            WHERE id= v_id ;
            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

        IF (v_b_exists = 0) THEN BEGIN
            INSERT INTO users(  
              name
              , apellido
              , email
              , email_verified_at
              , password
              , pass_crypt
              , referido
              , myrefcode
              , admin
              , telefono
              , empresa
              , remember_token
              , active
              , created_at
              , updated_at
              , usuario_legacy
              , medio_de_contacto
            )
            SELECT  v_name
            , v_apellido
            , v_email
            , v_email_verified_at
            , v_password
            , v_pass_crypt
            , v_referido
            , v_myrefcode
            , v_admin
            , v_telefono
            , v_empresa
            , v_remember_token
            , v_active
            , v_created_at
            , v_updated_at
            , v_usuario_legacy
            , v_medio_de_contacto

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_update_users`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_update_users`(IN `v_id` BIGINT(20)
  , IN `v_name` VARCHAR(200)
  , IN `v_apellido` VARCHAR(210)
  , IN `v_email` VARCHAR(220)
  , IN `v_email_verified_at` VARCHAR(230)
  , IN `v_password` VARCHAR(240)
  , IN `v_pass_crypt` VARCHAR(250)
  , IN `v_referido` VARCHAR(260)
  , IN `v_myrefcode` VARCHAR(270)
  , IN `v_admin` VARCHAR(280)
  , IN `v_telefono` VARCHAR(290)
  , IN `v_empresa` VARCHAR(300)
  , IN `v_remember_token` VARCHAR(310)
  , IN `v_active` VARCHAR(320)
  , IN `v_created_at` VARCHAR(330)
  , IN `v_updated_at` VARCHAR(340)
  , IN `v_usuario_legacy` VARCHAR(350)
  , IN `v_medio_de_contacto` VARCHAR(360)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
BEGIN

  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

  UPDATE users 
  SET name   = v_name
    , apellido   = v_apellido
    , email   = v_email
    , email_verified_at   = v_email_verified_at
    , password   = v_password
    , pass_crypt   = v_pass_crypt
    , referido   = v_referido
    , myrefcode   = v_myrefcode
    , admin   = v_admin
    , telefono   = v_telefono
    , empresa   = v_empresa
    , remember_token   = v_remember_token
    , active   = v_active
    , created_at   = v_created_at
    , updated_at   = v_updated_at
    , usuario_legacy   = v_usuario_legacy
    , medio_de_contacto   = v_medio_de_contacto
  WHERE id= v_id ;
  SET v_i_response := LAST_INSERT_ID();

END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_undo_delete_users`;
DELIMITER ;;
    CREATE PROCEDURE `sp_undo_delete_users`(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
    MODIFIES SQL DATA
    BEGIN
        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        UPDATE users SET active= 1
        WHERE id= v_id;
        SET v_i_internal_status:= ROW_COUNT();

    END ;;
DELIMITER ;

