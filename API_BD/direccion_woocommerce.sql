DROP PROCEDURE IF EXISTS `sp_delete_direccion_woocommerce`;
DELIMITER ;;
    CREATE PROCEDURE `sp_delete_direccion_woocommerce`(IN `v_iddirecciontienda` BIGINT(20), OUT `v_i_internal_status` INTEGER)
        MODIFIES SQL DATA
    BEGIN

        UPDATE direccion_woocommerce  SET Activo= 0
        WHERE iddirecciontienda= v_iddirecciontienda;
        SET v_i_internal_status:= ROW_COUNT();
    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_get_direccion_woocommerce`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_direccion_woocommerce`( b_filtro_like bool
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
                                WHEN i_colum_order=0 THEN CONCAT("  ORDER BY iddirecciontienda ",vc_order_direct)
                                WHEN i_colum_order=1 THEN CONCAT("  ORDER BY id_cliente ",vc_order_direct)
                                WHEN i_colum_order=2 THEN CONCAT("  ORDER BY url ",vc_order_direct)
                                WHEN i_colum_order=3 THEN CONCAT("  ORDER BY nombre ",vc_order_direct)
                                WHEN i_colum_order=4 THEN CONCAT("  ORDER BY empresa ",vc_order_direct)
                                WHEN i_colum_order=5 THEN CONCAT("  ORDER BY correo ",vc_order_direct)
                                WHEN i_colum_order=6 THEN CONCAT("  ORDER BY telefono ",vc_order_direct)
                                WHEN i_colum_order=7 THEN CONCAT("  ORDER BY calle ",vc_order_direct)
                                WHEN i_colum_order=8 THEN CONCAT("  ORDER BY colonia ",vc_order_direct)
                                WHEN i_colum_order=9 THEN CONCAT("  ORDER BY ciudad ",vc_order_direct)
                                WHEN i_colum_order=10 THEN CONCAT(" ORDER BY codigo_postal ",vc_order_direct)
                                ELSE ""
            END;

            SET @_QUERY:=CONCAT("SELECT   iddirecciontienda AS id
                                        , id_cliente
                                        , url
                                        , nombre
                                        , empresa
                                        , correo
                                        , telefono
                                        , calle
                                        , colonia
                                        , ciudad
                                        , codigo_postal
                                    FROM direccion_woocommerce 
                                    WHERE direccion_woocommerce.Activo > 0 "
            );

            IF(b_filtro_like=true) THEN BEGIN

                SET @_QUERY:=CONCAT(@_QUERY, " AND (id_cliente LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  url LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  nombre LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  empresa LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  correo LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  telefono LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  calle LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  colonia LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  ciudad LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  codigo_postal LIKE '%",TRIM(vc_string_filtro),"%')");

            END; END IF;

            IF(i_colum_order IS NOT NULL) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
            END; END IF;

            IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
            END; END IF;

            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

            SELECT COUNT(*) INTO v_registro_total FROM direccion_woocommerce WHERE Activo > 0;
        END ;;
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_get_direccion_woocommerce_by_id`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_direccion_woocommerce_by_id`(IN `v_iddirecciontienda` BIGINT(20))
      READS SQL DATA DETERMINISTIC
      BEGIN
          SELECT iddirecciontienda AS id
          , id_cliente
          , url
          , nombre
          , empresa
          , correo 
          , telefono 
          , calle 
          , colonia 
          , ciudad 
          , codigo_postal 
          , estado 
          , pais 
          , activo 
          FROM direccion_woocommerce
          WHERE iddirecciontienda= v_iddirecciontienda AND Activo > 0
          LIMIT 1 ;  
      END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_set_direccion_woocommerce`;
DELIMITER ;;
CREATE PROCEDURE `sp_set_direccion_woocommerce`(
    IN `v_id_cliente` VARCHAR(200)
  , IN `v_url` VARCHAR(210)
  , IN `v_nombre` VARCHAR(220)
  , IN `v_empresa` VARCHAR(230)
  , IN `v_correo` VARCHAR(240)
  , IN `v_telefono` VARCHAR(250)
  , IN `v_calle` VARCHAR(260)
  , IN `v_colonia` VARCHAR(270)
  , IN `v_ciudad` VARCHAR(280)
  , IN `v_codigo_postal` VARCHAR(290)
  , IN `v_estado` VARCHAR(300)
  , IN `v_pais` VARCHAR(310)
  , IN `v_activo` VARCHAR(320)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
        BEGIN

            DECLARE v_b_exists INTEGER(1) ;

            SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

            INSERT INTO direccion_woocommerce(  
              id_cliente
              , url
              , nombre
              , empresa
              , correo
              , telefono
              , calle
              , colonia
              , ciudad
              , codigo_postal
              , estado
              , pais
              , activo
            )
            SELECT  v_id_cliente
            , v_url
            , v_nombre
            , v_empresa
            , v_correo
            , v_telefono
            , v_calle
            , v_colonia
            , v_ciudad
            , v_codigo_postal
            , v_estado
            , v_pais
            , v_activo

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_importar_direccion_woocommerce`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_importar_direccion_woocommerce`(IN `v_iddirecciontienda` BIGINT(20)
  , IN `v_id_cliente` VARCHAR(200)
  , IN `v_url` VARCHAR(210)
  , IN `v_nombre` VARCHAR(220)
  , IN `v_empresa` VARCHAR(230)
  , IN `v_correo` VARCHAR(240)
  , IN `v_telefono` VARCHAR(250)
  , IN `v_calle` VARCHAR(260)
  , IN `v_colonia` VARCHAR(270)
  , IN `v_ciudad` VARCHAR(280)
  , IN `v_codigo_postal` VARCHAR(290)
  , IN `v_estado` VARCHAR(300)
  , IN `v_pais` VARCHAR(310)
  , IN `v_activo` VARCHAR(320)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
    BEGIN

        DECLARE v_b_exists INTEGER(1) ;

        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        SELECT COUNT(*) INTO v_b_exists 
        FROM direccion_woocommerce 
        WHERE iddirecciontienda= v_iddirecciontienda AND Activo > 0 LIMIT 1 ;

        IF (v_b_exists > 0) THEN BEGIN
            UPDATE direccion_woocommerce 
            SET id_cliente   = v_id_cliente
              , url   = v_url
              , nombre   = v_nombre
              , empresa   = v_empresa
              , correo   = v_correo
              , telefono   = v_telefono
              , calle   = v_calle
              , colonia   = v_colonia
              , ciudad   = v_ciudad
              , codigo_postal   = v_codigo_postal
              , estado   = v_estado
              , pais   = v_pais
              , activo   = v_activo
            WHERE iddirecciontienda= v_iddirecciontienda ;
            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

        IF (v_b_exists = 0) THEN BEGIN
            INSERT INTO direccion_woocommerce(  
              id_cliente
              , url
              , nombre
              , empresa
              , correo
              , telefono
              , calle
              , colonia
              , ciudad
              , codigo_postal
              , estado
              , pais
              , activo
            )
            SELECT  v_id_cliente
            , v_url
            , v_nombre
            , v_empresa
            , v_correo
            , v_telefono
            , v_calle
            , v_colonia
            , v_ciudad
            , v_codigo_postal
            , v_estado
            , v_pais
            , v_activo

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_update_direccion_woocommerce`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_update_direccion_woocommerce`(IN `v_iddirecciontienda` BIGINT(20)
  , IN `v_id_cliente` VARCHAR(200)
  , IN `v_url` VARCHAR(210)
  , IN `v_nombre` VARCHAR(220)
  , IN `v_empresa` VARCHAR(230)
  , IN `v_correo` VARCHAR(240)
  , IN `v_telefono` VARCHAR(250)
  , IN `v_calle` VARCHAR(260)
  , IN `v_colonia` VARCHAR(270)
  , IN `v_ciudad` VARCHAR(280)
  , IN `v_codigo_postal` VARCHAR(290)
  , IN `v_estado` VARCHAR(300)
  , IN `v_pais` VARCHAR(310)
  , IN `v_activo` VARCHAR(320)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
BEGIN

  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

  UPDATE direccion_woocommerce 
  SET id_cliente   = v_id_cliente
    , url   = v_url
    , nombre   = v_nombre
    , empresa   = v_empresa
    , correo   = v_correo
    , telefono   = v_telefono
    , calle   = v_calle
    , colonia   = v_colonia
    , ciudad   = v_ciudad
    , codigo_postal   = v_codigo_postal
    , estado   = v_estado
    , pais   = v_pais
    , activo   = v_activo
  WHERE iddirecciontienda= v_iddirecciontienda ;
  SET v_i_response := LAST_INSERT_ID();

END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_undo_delete_direccion_woocommerce`;
DELIMITER ;;
    CREATE PROCEDURE `sp_undo_delete_direccion_woocommerce`(IN `v_iddirecciontienda` BIGINT(20), OUT `v_i_internal_status` INTEGER)
    MODIFIES SQL DATA
    BEGIN
        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        UPDATE direccion_woocommerce SET Activo= 1
        WHERE iddirecciontienda= v_iddirecciontienda;
        SET v_i_internal_status:= ROW_COUNT();

    END ;;
DELIMITER ;

