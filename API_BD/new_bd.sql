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
          , vCampo14_direccion_woocommerce 
          , vCampo15_direccion_woocommerce 
          , vCampo16_direccion_woocommerce 
          , vCampo17_direccion_woocommerce 
          , vCampo18_direccion_woocommerce 
          , vCampo19_direccion_woocommerce 
          , vCampo20_direccion_woocommerce 
          , vCampo21_direccion_woocommerce 
          , vCampo22_direccion_woocommerce 
          , vCampo23_direccion_woocommerce 
          , vCampo24_direccion_woocommerce 
          , vCampo25_direccion_woocommerce 
          , vCampo26_direccion_woocommerce 
          , vCampo27_direccion_woocommerce 
          , vCampo28_direccion_woocommerce 
          , vCampo29_direccion_woocommerce 
          , vCampo30_direccion_woocommerce 
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
  , IN `v_vCampo14_direccion_woocommerce` VARCHAR(330)
  , IN `v_vCampo15_direccion_woocommerce` VARCHAR(340)
  , IN `v_vCampo16_direccion_woocommerce` VARCHAR(350)
  , IN `v_vCampo17_direccion_woocommerce` VARCHAR(360)
  , IN `v_vCampo18_direccion_woocommerce` VARCHAR(370)
  , IN `v_vCampo19_direccion_woocommerce` VARCHAR(380)
  , IN `v_vCampo20_direccion_woocommerce` VARCHAR(390)
  , IN `v_vCampo21_direccion_woocommerce` VARCHAR(400)
  , IN `v_vCampo22_direccion_woocommerce` VARCHAR(410)
  , IN `v_vCampo23_direccion_woocommerce` VARCHAR(420)
  , IN `v_vCampo24_direccion_woocommerce` VARCHAR(430)
  , IN `v_vCampo25_direccion_woocommerce` VARCHAR(440)
  , IN `v_vCampo26_direccion_woocommerce` VARCHAR(450)
  , IN `v_vCampo27_direccion_woocommerce` VARCHAR(460)
  , IN `v_vCampo28_direccion_woocommerce` VARCHAR(470)
  , IN `v_vCampo29_direccion_woocommerce` VARCHAR(480)
  , IN `v_vCampo30_direccion_woocommerce` VARCHAR(490)
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
              , vCampo14_direccion_woocommerce
              , vCampo15_direccion_woocommerce
              , vCampo16_direccion_woocommerce
              , vCampo17_direccion_woocommerce
              , vCampo18_direccion_woocommerce
              , vCampo19_direccion_woocommerce
              , vCampo20_direccion_woocommerce
              , vCampo21_direccion_woocommerce
              , vCampo22_direccion_woocommerce
              , vCampo23_direccion_woocommerce
              , vCampo24_direccion_woocommerce
              , vCampo25_direccion_woocommerce
              , vCampo26_direccion_woocommerce
              , vCampo27_direccion_woocommerce
              , vCampo28_direccion_woocommerce
              , vCampo29_direccion_woocommerce
              , vCampo30_direccion_woocommerce
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
            , v_vCampo14_direccion_woocommerce
            , v_vCampo15_direccion_woocommerce
            , v_vCampo16_direccion_woocommerce
            , v_vCampo17_direccion_woocommerce
            , v_vCampo18_direccion_woocommerce
            , v_vCampo19_direccion_woocommerce
            , v_vCampo20_direccion_woocommerce
            , v_vCampo21_direccion_woocommerce
            , v_vCampo22_direccion_woocommerce
            , v_vCampo23_direccion_woocommerce
            , v_vCampo24_direccion_woocommerce
            , v_vCampo25_direccion_woocommerce
            , v_vCampo26_direccion_woocommerce
            , v_vCampo27_direccion_woocommerce
            , v_vCampo28_direccion_woocommerce
            , v_vCampo29_direccion_woocommerce
            , v_vCampo30_direccion_woocommerce

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
  , IN `v_vCampo14_direccion_woocommerce` VARCHAR(330)
  , IN `v_vCampo15_direccion_woocommerce` VARCHAR(340)
  , IN `v_vCampo16_direccion_woocommerce` VARCHAR(350)
  , IN `v_vCampo17_direccion_woocommerce` VARCHAR(360)
  , IN `v_vCampo18_direccion_woocommerce` VARCHAR(370)
  , IN `v_vCampo19_direccion_woocommerce` VARCHAR(380)
  , IN `v_vCampo20_direccion_woocommerce` VARCHAR(390)
  , IN `v_vCampo21_direccion_woocommerce` VARCHAR(400)
  , IN `v_vCampo22_direccion_woocommerce` VARCHAR(410)
  , IN `v_vCampo23_direccion_woocommerce` VARCHAR(420)
  , IN `v_vCampo24_direccion_woocommerce` VARCHAR(430)
  , IN `v_vCampo25_direccion_woocommerce` VARCHAR(440)
  , IN `v_vCampo26_direccion_woocommerce` VARCHAR(450)
  , IN `v_vCampo27_direccion_woocommerce` VARCHAR(460)
  , IN `v_vCampo28_direccion_woocommerce` VARCHAR(470)
  , IN `v_vCampo29_direccion_woocommerce` VARCHAR(480)
  , IN `v_vCampo30_direccion_woocommerce` VARCHAR(490)
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
              , vCampo14_direccion_woocommerce   = v_vCampo14_direccion_woocommerce
              , vCampo15_direccion_woocommerce   = v_vCampo15_direccion_woocommerce
              , vCampo16_direccion_woocommerce   = v_vCampo16_direccion_woocommerce
              , vCampo17_direccion_woocommerce   = v_vCampo17_direccion_woocommerce
              , vCampo18_direccion_woocommerce   = v_vCampo18_direccion_woocommerce
              , vCampo19_direccion_woocommerce   = v_vCampo19_direccion_woocommerce
              , vCampo20_direccion_woocommerce   = v_vCampo20_direccion_woocommerce
              , vCampo21_direccion_woocommerce   = v_vCampo21_direccion_woocommerce
              , vCampo22_direccion_woocommerce   = v_vCampo22_direccion_woocommerce
              , vCampo23_direccion_woocommerce   = v_vCampo23_direccion_woocommerce
              , vCampo24_direccion_woocommerce   = v_vCampo24_direccion_woocommerce
              , vCampo25_direccion_woocommerce   = v_vCampo25_direccion_woocommerce
              , vCampo26_direccion_woocommerce   = v_vCampo26_direccion_woocommerce
              , vCampo27_direccion_woocommerce   = v_vCampo27_direccion_woocommerce
              , vCampo28_direccion_woocommerce   = v_vCampo28_direccion_woocommerce
              , vCampo29_direccion_woocommerce   = v_vCampo29_direccion_woocommerce
              , vCampo30_direccion_woocommerce   = v_vCampo30_direccion_woocommerce
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
              , vCampo14_direccion_woocommerce
              , vCampo15_direccion_woocommerce
              , vCampo16_direccion_woocommerce
              , vCampo17_direccion_woocommerce
              , vCampo18_direccion_woocommerce
              , vCampo19_direccion_woocommerce
              , vCampo20_direccion_woocommerce
              , vCampo21_direccion_woocommerce
              , vCampo22_direccion_woocommerce
              , vCampo23_direccion_woocommerce
              , vCampo24_direccion_woocommerce
              , vCampo25_direccion_woocommerce
              , vCampo26_direccion_woocommerce
              , vCampo27_direccion_woocommerce
              , vCampo28_direccion_woocommerce
              , vCampo29_direccion_woocommerce
              , vCampo30_direccion_woocommerce
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
            , v_vCampo14_direccion_woocommerce
            , v_vCampo15_direccion_woocommerce
            , v_vCampo16_direccion_woocommerce
            , v_vCampo17_direccion_woocommerce
            , v_vCampo18_direccion_woocommerce
            , v_vCampo19_direccion_woocommerce
            , v_vCampo20_direccion_woocommerce
            , v_vCampo21_direccion_woocommerce
            , v_vCampo22_direccion_woocommerce
            , v_vCampo23_direccion_woocommerce
            , v_vCampo24_direccion_woocommerce
            , v_vCampo25_direccion_woocommerce
            , v_vCampo26_direccion_woocommerce
            , v_vCampo27_direccion_woocommerce
            , v_vCampo28_direccion_woocommerce
            , v_vCampo29_direccion_woocommerce
            , v_vCampo30_direccion_woocommerce

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
  , IN `v_vCampo14_direccion_woocommerce` VARCHAR(330)
  , IN `v_vCampo15_direccion_woocommerce` VARCHAR(340)
  , IN `v_vCampo16_direccion_woocommerce` VARCHAR(350)
  , IN `v_vCampo17_direccion_woocommerce` VARCHAR(360)
  , IN `v_vCampo18_direccion_woocommerce` VARCHAR(370)
  , IN `v_vCampo19_direccion_woocommerce` VARCHAR(380)
  , IN `v_vCampo20_direccion_woocommerce` VARCHAR(390)
  , IN `v_vCampo21_direccion_woocommerce` VARCHAR(400)
  , IN `v_vCampo22_direccion_woocommerce` VARCHAR(410)
  , IN `v_vCampo23_direccion_woocommerce` VARCHAR(420)
  , IN `v_vCampo24_direccion_woocommerce` VARCHAR(430)
  , IN `v_vCampo25_direccion_woocommerce` VARCHAR(440)
  , IN `v_vCampo26_direccion_woocommerce` VARCHAR(450)
  , IN `v_vCampo27_direccion_woocommerce` VARCHAR(460)
  , IN `v_vCampo28_direccion_woocommerce` VARCHAR(470)
  , IN `v_vCampo29_direccion_woocommerce` VARCHAR(480)
  , IN `v_vCampo30_direccion_woocommerce` VARCHAR(490)
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
    , vCampo14_direccion_woocommerce   = v_vCampo14_direccion_woocommerce
    , vCampo15_direccion_woocommerce   = v_vCampo15_direccion_woocommerce
    , vCampo16_direccion_woocommerce   = v_vCampo16_direccion_woocommerce
    , vCampo17_direccion_woocommerce   = v_vCampo17_direccion_woocommerce
    , vCampo18_direccion_woocommerce   = v_vCampo18_direccion_woocommerce
    , vCampo19_direccion_woocommerce   = v_vCampo19_direccion_woocommerce
    , vCampo20_direccion_woocommerce   = v_vCampo20_direccion_woocommerce
    , vCampo21_direccion_woocommerce   = v_vCampo21_direccion_woocommerce
    , vCampo22_direccion_woocommerce   = v_vCampo22_direccion_woocommerce
    , vCampo23_direccion_woocommerce   = v_vCampo23_direccion_woocommerce
    , vCampo24_direccion_woocommerce   = v_vCampo24_direccion_woocommerce
    , vCampo25_direccion_woocommerce   = v_vCampo25_direccion_woocommerce
    , vCampo26_direccion_woocommerce   = v_vCampo26_direccion_woocommerce
    , vCampo27_direccion_woocommerce   = v_vCampo27_direccion_woocommerce
    , vCampo28_direccion_woocommerce   = v_vCampo28_direccion_woocommerce
    , vCampo29_direccion_woocommerce   = v_vCampo29_direccion_woocommerce
    , vCampo30_direccion_woocommerce   = v_vCampo30_direccion_woocommerce
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

