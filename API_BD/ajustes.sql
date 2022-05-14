DROP PROCEDURE IF EXISTS `sp_delete_ajustes`;
DELIMITER ;;
    CREATE PROCEDURE `sp_delete_ajustes`(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
        MODIFIES SQL DATA
    BEGIN

        UPDATE ajustes  SET activo= 0
        WHERE id= v_id;
        SET v_i_internal_status:= ROW_COUNT();
    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_get_ajustes`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_ajustes`( b_filtro_like bool
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
                                WHEN i_colum_order=1 THEN CONCAT("  ORDER BY nombre ",vc_order_direct)
                                WHEN i_colum_order=2 THEN CONCAT("  ORDER BY valor ",vc_order_direct)
                                WHEN i_colum_order=3 THEN CONCAT("  ORDER BY valor_encrypt ",vc_order_direct)
                                WHEN i_colum_order=4 THEN CONCAT("  ORDER BY descripcion ",vc_order_direct)
                                WHEN i_colum_order=5 THEN CONCAT("  ORDER BY activo ",vc_order_direct)
                                WHEN i_colum_order=6 THEN CONCAT("  ORDER BY creado ",vc_order_direct)
                                WHEN i_colum_order=7 THEN CONCAT("  ORDER BY creado_por ",vc_order_direct)
                                WHEN i_colum_order=8 THEN CONCAT("  ORDER BY modificado ",vc_order_direct)
                                WHEN i_colum_order=9 THEN CONCAT("  ORDER BY modificado_por ",vc_order_direct)
                                ELSE ""
            END;

            SET @_QUERY:=CONCAT("SELECT   id AS id
                                        , nombre
                                        , valor
                                        , valor_encrypt
                                        , descripcion
                                        , activo
                                        , creado
                                        , creado_por
                                        , modificado
                                        , modificado_por
                                    FROM ajustes 
                                    WHERE ajustes.activo > 0 "
            );

            IF(b_filtro_like=true) THEN BEGIN

                SET @_QUERY:=CONCAT(@_QUERY, " AND (nombre LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  valor LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  valor_encrypt LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  descripcion LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  activo LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  creado LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  creado_por LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  modificado LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  modificado_por LIKE '%",TRIM(vc_string_filtro),"%'");
            END; END IF;

            IF(i_colum_order IS NOT NULL) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
            END; END IF;

            IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
            END; END IF;

            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

            SELECT COUNT(*) INTO v_registro_total FROM ajustes WHERE activo > 0;
        END ;;
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_get_ajustes_by_id`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_ajustes_by_id`(IN `v_id` BIGINT(20))
      READS SQL DATA DETERMINISTIC
      BEGIN
          SELECT id AS id
          , nombre
          , valor
          , valor_encrypt
          , descripcion
          , activo 
          , creado 
          , creado_por 
          , modificado 
          , modificado_por 
          FROM ajustes
          WHERE id= v_id AND activo > 0
          LIMIT 1 ;  
      END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_set_ajustes`;
DELIMITER ;;
CREATE PROCEDURE `sp_set_ajustes`(
    IN `v_nombre` VARCHAR(200)
  , IN `v_valor` VARCHAR(210)
  , IN `v_valor_encrypt` VARCHAR(220)
  , IN `v_descripcion` VARCHAR(230)
  , IN `v_activo` VARCHAR(240)
  , IN `v_creado` VARCHAR(250)
  , IN `v_creado_por` VARCHAR(260)
  , IN `v_modificado` VARCHAR(270)
  , IN `v_modificado_por` VARCHAR(280)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
        BEGIN

            DECLARE v_b_exists INTEGER(1) ;

            SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

            INSERT INTO ajustes(  
              nombre
              , valor
              , valor_encrypt
              , descripcion
              , activo
              , creado
              , creado_por
              , modificado
              , modificado_por
            )
            SELECT  v_nombre
            , v_valor
            , v_valor_encrypt
            , v_descripcion
            , v_activo
            , v_creado
            , v_creado_por
            , v_modificado
            , v_modificado_por

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_importar_ajustes`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_importar_ajustes`(IN `v_id` BIGINT(20)
  , IN `v_nombre` VARCHAR(200)
  , IN `v_valor` VARCHAR(210)
  , IN `v_valor_encrypt` VARCHAR(220)
  , IN `v_descripcion` VARCHAR(230)
  , IN `v_activo` VARCHAR(240)
  , IN `v_creado` VARCHAR(250)
  , IN `v_creado_por` VARCHAR(260)
  , IN `v_modificado` VARCHAR(270)
  , IN `v_modificado_por` VARCHAR(280)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
    BEGIN

        DECLARE v_b_exists INTEGER(1) ;

        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        SELECT COUNT(*) INTO v_b_exists 
        FROM ajustes 
        WHERE id= v_id AND activo > 0 LIMIT 1 ;

        IF (v_b_exists > 0) THEN BEGIN
            UPDATE ajustes 
            SET nombre   = v_nombre
              , valor   = v_valor
              , valor_encrypt   = v_valor_encrypt
              , descripcion   = v_descripcion
              , activo   = v_activo
              , creado   = v_creado
              , creado_por   = v_creado_por
              , modificado   = v_modificado
              , modificado_por   = v_modificado_por
            WHERE id= v_id ;
            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

        IF (v_b_exists = 0) THEN BEGIN
            INSERT INTO ajustes(  
              nombre
              , valor
              , valor_encrypt
              , descripcion
              , activo
              , creado
              , creado_por
              , modificado
              , modificado_por
            )
            SELECT  v_nombre
            , v_valor
            , v_valor_encrypt
            , v_descripcion
            , v_activo
            , v_creado
            , v_creado_por
            , v_modificado
            , v_modificado_por

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_update_ajustes`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_update_ajustes`(IN `v_id` BIGINT(20)
  , IN `v_nombre` VARCHAR(200)
  , IN `v_valor` VARCHAR(210)
  , IN `v_valor_encrypt` VARCHAR(220)
  , IN `v_descripcion` VARCHAR(230)
  , IN `v_activo` VARCHAR(240)
  , IN `v_creado` VARCHAR(250)
  , IN `v_creado_por` VARCHAR(260)
  , IN `v_modificado` VARCHAR(270)
  , IN `v_modificado_por` VARCHAR(280)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
BEGIN

  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

  UPDATE ajustes 
  SET nombre   = v_nombre
    , valor   = v_valor
    , valor_encrypt   = v_valor_encrypt
    , descripcion   = v_descripcion
    , activo   = v_activo
    , creado   = v_creado
    , creado_por   = v_creado_por
    , modificado   = v_modificado
    , modificado_por   = v_modificado_por
  WHERE id= v_id ;
  SET v_i_response := LAST_INSERT_ID();

END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_undo_delete_ajustes`;
DELIMITER ;;
    CREATE PROCEDURE `sp_undo_delete_ajustes`(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
    MODIFIES SQL DATA
    BEGIN
        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        UPDATE ajustes SET activo= 1
        WHERE id= v_id;
        SET v_i_internal_status:= ROW_COUNT();

    END ;;
DELIMITER ;

