DROP PROCEDURE IF EXISTS `sp_delete_precios`;
DELIMITER ;;
    CREATE PROCEDURE `sp_delete_precios`(IN `v_IdPrecios` BIGINT(20), OUT `v_i_internal_status` INTEGER)
        MODIFIES SQL DATA
    BEGIN

        UPDATE precios  SET Activo= 0
        WHERE IdPrecios= v_IdPrecios;
        SET v_i_internal_status:= ROW_COUNT();
    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_get_precios`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_precios`( b_filtro_like bool
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
                                WHEN i_colum_order=0 THEN CONCAT("  ORDER BY IdPrecios ",vc_order_direct)
                                WHEN i_colum_order=1 THEN CONCAT("  ORDER BY IdTipoEnvio ",vc_order_direct)
                                WHEN i_colum_order=2 THEN CONCAT("  ORDER BY Precio ",vc_order_direct)
                                WHEN i_colum_order=3 THEN CONCAT("  ORDER BY PesoInicio ",vc_order_direct)
                                WHEN i_colum_order=4 THEN CONCAT("  ORDER BY PesoFin ",vc_order_direct)
                                WHEN i_colum_order=5 THEN CONCAT("  ORDER BY MedidaMaxima ",vc_order_direct)
                                WHEN i_colum_order=6 THEN CONCAT("  ORDER BY DimensionMaxima ",vc_order_direct)
                                WHEN i_colum_order=7 THEN CONCAT("  ORDER BY costo_extra_kg ",vc_order_direct)
                                WHEN i_colum_order=8 THEN CONCAT("  ORDER BY peso_maximo ",vc_order_direct)
                                WHEN i_colum_order=9 THEN CONCAT("  ORDER BY Activo ",vc_order_direct)
                                WHEN i_colum_order=10 THEN CONCAT(" ORDER BY Creado ",vc_order_direct)
                                ELSE ""
            END;

            SET @_QUERY:=CONCAT("SELECT   IdPrecios AS id
                                        , IdTipoEnvio
                                        , Precio
                                        , PesoInicio
                                        , PesoFin
                                        , MedidaMaxima
                                        , DimensionMaxima
                                        , costo_extra_kg
                                        , peso_maximo
                                        , Activo
                                        , Creado
                                    FROM precios 
                                    WHERE precios.Activo > 0 "
            );

            IF(b_filtro_like=true) THEN BEGIN

                SET @_QUERY:=CONCAT(@_QUERY, " AND (IdTipoEnvio LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  Precio LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  PesoInicio LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  PesoFin LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  MedidaMaxima LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  DimensionMaxima LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  costo_extra_kg LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  peso_maximo LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  Activo LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  Creado LIKE '%",TRIM(vc_string_filtro),"%')");

            END; END IF;

            IF(i_colum_order IS NOT NULL) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
            END; END IF;

            IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
            END; END IF;

            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

            SELECT COUNT(*) INTO v_registro_total FROM precios WHERE Activo > 0;
        END ;;
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_get_precios_by_id`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_precios_by_id`(IN `v_IdPrecios` BIGINT(20))
      READS SQL DATA DETERMINISTIC
      BEGIN
          SELECT IdPrecios AS id
          , IdTipoEnvio
          , Precio
          , PesoInicio
          , PesoFin
          , MedidaMaxima 
          , DimensionMaxima 
          , costo_extra_kg 
          , peso_maximo 
          , Activo 
          , Creado 
          , CreadoPor 
          , Modificado 
          , ModificadoPor 
          , vCampo14_precios 
          , vCampo15_precios 
          , vCampo16_precios 
          , vCampo17_precios 
          , vCampo18_precios 
          , vCampo19_precios 
          , vCampo20_precios 
          , vCampo21_precios 
          , vCampo22_precios 
          , vCampo23_precios 
          , vCampo24_precios 
          , vCampo25_precios 
          , vCampo26_precios 
          , vCampo27_precios 
          , vCampo28_precios 
          , vCampo29_precios 
          , vCampo30_precios 
          FROM precios
          WHERE IdPrecios= v_IdPrecios AND Activo > 0
          LIMIT 1 ;  
      END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_set_precios`;
DELIMITER ;;
CREATE PROCEDURE `sp_set_precios`(
    IN `v_IdTipoEnvio` VARCHAR(200)
  , IN `v_Precio` VARCHAR(210)
  , IN `v_PesoInicio` VARCHAR(220)
  , IN `v_PesoFin` VARCHAR(230)
  , IN `v_MedidaMaxima` VARCHAR(240)
  , IN `v_DimensionMaxima` VARCHAR(250)
  , IN `v_costo_extra_kg` VARCHAR(260)
  , IN `v_peso_maximo` VARCHAR(270)
  , IN `v_Activo` VARCHAR(280)
  , IN `v_Creado` VARCHAR(290)
  , IN `v_CreadoPor` VARCHAR(300)
  , IN `v_Modificado` VARCHAR(310)
  , IN `v_ModificadoPor` VARCHAR(320)
  , IN `v_vCampo14_precios` VARCHAR(330)
  , IN `v_vCampo15_precios` VARCHAR(340)
  , IN `v_vCampo16_precios` VARCHAR(350)
  , IN `v_vCampo17_precios` VARCHAR(360)
  , IN `v_vCampo18_precios` VARCHAR(370)
  , IN `v_vCampo19_precios` VARCHAR(380)
  , IN `v_vCampo20_precios` VARCHAR(390)
  , IN `v_vCampo21_precios` VARCHAR(400)
  , IN `v_vCampo22_precios` VARCHAR(410)
  , IN `v_vCampo23_precios` VARCHAR(420)
  , IN `v_vCampo24_precios` VARCHAR(430)
  , IN `v_vCampo25_precios` VARCHAR(440)
  , IN `v_vCampo26_precios` VARCHAR(450)
  , IN `v_vCampo27_precios` VARCHAR(460)
  , IN `v_vCampo28_precios` VARCHAR(470)
  , IN `v_vCampo29_precios` VARCHAR(480)
  , IN `v_vCampo30_precios` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
        BEGIN

            DECLARE v_b_exists INTEGER(1) ;

            SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

            INSERT INTO precios(  
              IdTipoEnvio
              , Precio
              , PesoInicio
              , PesoFin
              , MedidaMaxima
              , DimensionMaxima
              , costo_extra_kg
              , peso_maximo
              , Activo
              , Creado
              , CreadoPor
              , Modificado
              , ModificadoPor
              , vCampo14_precios
              , vCampo15_precios
              , vCampo16_precios
              , vCampo17_precios
              , vCampo18_precios
              , vCampo19_precios
              , vCampo20_precios
              , vCampo21_precios
              , vCampo22_precios
              , vCampo23_precios
              , vCampo24_precios
              , vCampo25_precios
              , vCampo26_precios
              , vCampo27_precios
              , vCampo28_precios
              , vCampo29_precios
              , vCampo30_precios
            )
            SELECT  v_IdTipoEnvio
            , v_Precio
            , v_PesoInicio
            , v_PesoFin
            , v_MedidaMaxima
            , v_DimensionMaxima
            , v_costo_extra_kg
            , v_peso_maximo
            , v_Activo
            , v_Creado
            , v_CreadoPor
            , v_Modificado
            , v_ModificadoPor
            , v_vCampo14_precios
            , v_vCampo15_precios
            , v_vCampo16_precios
            , v_vCampo17_precios
            , v_vCampo18_precios
            , v_vCampo19_precios
            , v_vCampo20_precios
            , v_vCampo21_precios
            , v_vCampo22_precios
            , v_vCampo23_precios
            , v_vCampo24_precios
            , v_vCampo25_precios
            , v_vCampo26_precios
            , v_vCampo27_precios
            , v_vCampo28_precios
            , v_vCampo29_precios
            , v_vCampo30_precios

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_importar_precios`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_importar_precios`(IN `v_IdPrecios` BIGINT(20)
  , IN `v_IdTipoEnvio` VARCHAR(200)
  , IN `v_Precio` VARCHAR(210)
  , IN `v_PesoInicio` VARCHAR(220)
  , IN `v_PesoFin` VARCHAR(230)
  , IN `v_MedidaMaxima` VARCHAR(240)
  , IN `v_DimensionMaxima` VARCHAR(250)
  , IN `v_costo_extra_kg` VARCHAR(260)
  , IN `v_peso_maximo` VARCHAR(270)
  , IN `v_Activo` VARCHAR(280)
  , IN `v_Creado` VARCHAR(290)
  , IN `v_CreadoPor` VARCHAR(300)
  , IN `v_Modificado` VARCHAR(310)
  , IN `v_ModificadoPor` VARCHAR(320)
  , IN `v_vCampo14_precios` VARCHAR(330)
  , IN `v_vCampo15_precios` VARCHAR(340)
  , IN `v_vCampo16_precios` VARCHAR(350)
  , IN `v_vCampo17_precios` VARCHAR(360)
  , IN `v_vCampo18_precios` VARCHAR(370)
  , IN `v_vCampo19_precios` VARCHAR(380)
  , IN `v_vCampo20_precios` VARCHAR(390)
  , IN `v_vCampo21_precios` VARCHAR(400)
  , IN `v_vCampo22_precios` VARCHAR(410)
  , IN `v_vCampo23_precios` VARCHAR(420)
  , IN `v_vCampo24_precios` VARCHAR(430)
  , IN `v_vCampo25_precios` VARCHAR(440)
  , IN `v_vCampo26_precios` VARCHAR(450)
  , IN `v_vCampo27_precios` VARCHAR(460)
  , IN `v_vCampo28_precios` VARCHAR(470)
  , IN `v_vCampo29_precios` VARCHAR(480)
  , IN `v_vCampo30_precios` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
    BEGIN

        DECLARE v_b_exists INTEGER(1) ;

        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        SELECT COUNT(*) INTO v_b_exists 
        FROM precios 
        WHERE IdPrecios= v_IdPrecios AND Activo > 0 LIMIT 1 ;

        IF (v_b_exists > 0) THEN BEGIN
            UPDATE precios 
            SET IdTipoEnvio   = v_IdTipoEnvio
              , Precio   = v_Precio
              , PesoInicio   = v_PesoInicio
              , PesoFin   = v_PesoFin
              , MedidaMaxima   = v_MedidaMaxima
              , DimensionMaxima   = v_DimensionMaxima
              , costo_extra_kg   = v_costo_extra_kg
              , peso_maximo   = v_peso_maximo
              , Activo   = v_Activo
              , Creado   = v_Creado
              , CreadoPor   = v_CreadoPor
              , Modificado   = v_Modificado
              , ModificadoPor   = v_ModificadoPor
              , vCampo14_precios   = v_vCampo14_precios
              , vCampo15_precios   = v_vCampo15_precios
              , vCampo16_precios   = v_vCampo16_precios
              , vCampo17_precios   = v_vCampo17_precios
              , vCampo18_precios   = v_vCampo18_precios
              , vCampo19_precios   = v_vCampo19_precios
              , vCampo20_precios   = v_vCampo20_precios
              , vCampo21_precios   = v_vCampo21_precios
              , vCampo22_precios   = v_vCampo22_precios
              , vCampo23_precios   = v_vCampo23_precios
              , vCampo24_precios   = v_vCampo24_precios
              , vCampo25_precios   = v_vCampo25_precios
              , vCampo26_precios   = v_vCampo26_precios
              , vCampo27_precios   = v_vCampo27_precios
              , vCampo28_precios   = v_vCampo28_precios
              , vCampo29_precios   = v_vCampo29_precios
              , vCampo30_precios   = v_vCampo30_precios
            WHERE IdPrecios= v_IdPrecios ;
            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

        IF (v_b_exists = 0) THEN BEGIN
            INSERT INTO precios(  
              IdTipoEnvio
              , Precio
              , PesoInicio
              , PesoFin
              , MedidaMaxima
              , DimensionMaxima
              , costo_extra_kg
              , peso_maximo
              , Activo
              , Creado
              , CreadoPor
              , Modificado
              , ModificadoPor
              , vCampo14_precios
              , vCampo15_precios
              , vCampo16_precios
              , vCampo17_precios
              , vCampo18_precios
              , vCampo19_precios
              , vCampo20_precios
              , vCampo21_precios
              , vCampo22_precios
              , vCampo23_precios
              , vCampo24_precios
              , vCampo25_precios
              , vCampo26_precios
              , vCampo27_precios
              , vCampo28_precios
              , vCampo29_precios
              , vCampo30_precios
            )
            SELECT  v_IdTipoEnvio
            , v_Precio
            , v_PesoInicio
            , v_PesoFin
            , v_MedidaMaxima
            , v_DimensionMaxima
            , v_costo_extra_kg
            , v_peso_maximo
            , v_Activo
            , v_Creado
            , v_CreadoPor
            , v_Modificado
            , v_ModificadoPor
            , v_vCampo14_precios
            , v_vCampo15_precios
            , v_vCampo16_precios
            , v_vCampo17_precios
            , v_vCampo18_precios
            , v_vCampo19_precios
            , v_vCampo20_precios
            , v_vCampo21_precios
            , v_vCampo22_precios
            , v_vCampo23_precios
            , v_vCampo24_precios
            , v_vCampo25_precios
            , v_vCampo26_precios
            , v_vCampo27_precios
            , v_vCampo28_precios
            , v_vCampo29_precios
            , v_vCampo30_precios

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_update_precios`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_update_precios`(IN `v_IdPrecios` BIGINT(20)
  , IN `v_IdTipoEnvio` VARCHAR(200)
  , IN `v_Precio` VARCHAR(210)
  , IN `v_PesoInicio` VARCHAR(220)
  , IN `v_PesoFin` VARCHAR(230)
  , IN `v_MedidaMaxima` VARCHAR(240)
  , IN `v_DimensionMaxima` VARCHAR(250)
  , IN `v_costo_extra_kg` VARCHAR(260)
  , IN `v_peso_maximo` VARCHAR(270)
  , IN `v_Activo` VARCHAR(280)
  , IN `v_Creado` VARCHAR(290)
  , IN `v_CreadoPor` VARCHAR(300)
  , IN `v_Modificado` VARCHAR(310)
  , IN `v_ModificadoPor` VARCHAR(320)
  , IN `v_vCampo14_precios` VARCHAR(330)
  , IN `v_vCampo15_precios` VARCHAR(340)
  , IN `v_vCampo16_precios` VARCHAR(350)
  , IN `v_vCampo17_precios` VARCHAR(360)
  , IN `v_vCampo18_precios` VARCHAR(370)
  , IN `v_vCampo19_precios` VARCHAR(380)
  , IN `v_vCampo20_precios` VARCHAR(390)
  , IN `v_vCampo21_precios` VARCHAR(400)
  , IN `v_vCampo22_precios` VARCHAR(410)
  , IN `v_vCampo23_precios` VARCHAR(420)
  , IN `v_vCampo24_precios` VARCHAR(430)
  , IN `v_vCampo25_precios` VARCHAR(440)
  , IN `v_vCampo26_precios` VARCHAR(450)
  , IN `v_vCampo27_precios` VARCHAR(460)
  , IN `v_vCampo28_precios` VARCHAR(470)
  , IN `v_vCampo29_precios` VARCHAR(480)
  , IN `v_vCampo30_precios` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
BEGIN

  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

  UPDATE precios 
  SET IdTipoEnvio   = v_IdTipoEnvio
    , Precio   = v_Precio
    , PesoInicio   = v_PesoInicio
    , PesoFin   = v_PesoFin
    , MedidaMaxima   = v_MedidaMaxima
    , DimensionMaxima   = v_DimensionMaxima
    , costo_extra_kg   = v_costo_extra_kg
    , peso_maximo   = v_peso_maximo
    , Activo   = v_Activo
    , Creado   = v_Creado
    , CreadoPor   = v_CreadoPor
    , Modificado   = v_Modificado
    , ModificadoPor   = v_ModificadoPor
    , vCampo14_precios   = v_vCampo14_precios
    , vCampo15_precios   = v_vCampo15_precios
    , vCampo16_precios   = v_vCampo16_precios
    , vCampo17_precios   = v_vCampo17_precios
    , vCampo18_precios   = v_vCampo18_precios
    , vCampo19_precios   = v_vCampo19_precios
    , vCampo20_precios   = v_vCampo20_precios
    , vCampo21_precios   = v_vCampo21_precios
    , vCampo22_precios   = v_vCampo22_precios
    , vCampo23_precios   = v_vCampo23_precios
    , vCampo24_precios   = v_vCampo24_precios
    , vCampo25_precios   = v_vCampo25_precios
    , vCampo26_precios   = v_vCampo26_precios
    , vCampo27_precios   = v_vCampo27_precios
    , vCampo28_precios   = v_vCampo28_precios
    , vCampo29_precios   = v_vCampo29_precios
    , vCampo30_precios   = v_vCampo30_precios
  WHERE IdPrecios= v_IdPrecios ;
  SET v_i_response := LAST_INSERT_ID();

END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_undo_delete_precios`;
DELIMITER ;;
    CREATE PROCEDURE `sp_undo_delete_precios`(IN `v_IdPrecios` BIGINT(20), OUT `v_i_internal_status` INTEGER)
    MODIFIES SQL DATA
    BEGIN
        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        UPDATE precios SET Activo= 1
        WHERE IdPrecios= v_IdPrecios;
        SET v_i_internal_status:= ROW_COUNT();

    END ;;
DELIMITER ;

