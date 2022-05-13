DROP PROCEDURE IF EXISTS `sp_delete_precios`;
DELIMITER ;;
    CREATE PROCEDURE `sp_delete_precios`(IN `v_id_precios` BIGINT(20), OUT `v_i_internal_status` INTEGER)
        MODIFIES SQL DATA
    BEGIN

        UPDATE tbl_precios  SET b_status= 0
        WHERE id_precios= v_id_precios;
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
                                WHEN i_colum_order=0 THEN CONCAT("  ORDER BY id_precios ",vc_order_direct)
                                WHEN i_colum_order=1 THEN CONCAT("  ORDER BY vCampo1_precios ",vc_order_direct)
                                WHEN i_colum_order=2 THEN CONCAT("  ORDER BY vCampo2_precios ",vc_order_direct)
                                WHEN i_colum_order=3 THEN CONCAT("  ORDER BY vCampo3_precios ",vc_order_direct)
                                WHEN i_colum_order=4 THEN CONCAT("  ORDER BY vCampo4_precios ",vc_order_direct)
                                WHEN i_colum_order=5 THEN CONCAT("  ORDER BY vCampo5_precios ",vc_order_direct)
                                WHEN i_colum_order=6 THEN CONCAT("  ORDER BY vCampo6_precios ",vc_order_direct)
                                WHEN i_colum_order=7 THEN CONCAT("  ORDER BY vCampo7_precios ",vc_order_direct)
                                WHEN i_colum_order=8 THEN CONCAT("  ORDER BY vCampo8_precios ",vc_order_direct)
                                WHEN i_colum_order=9 THEN CONCAT("  ORDER BY vCampo9_precios ",vc_order_direct)
                                WHEN i_colum_order=10 THEN CONCAT(" ORDER BY vCampo10_precios ",vc_order_direct)
                                ELSE ""
            END;

            SET @_QUERY:=CONCAT("SELECT   id_precios AS id
                                        , vCampo1_precios
                                        , vCampo2_precios
                                        , vCampo3_precios
                                        , vCampo4_precios
                                        , vCampo5_precios
                                        , vCampo6_precios
                                        , vCampo7_precios
                                        , vCampo8_precios
                                        , vCampo9_precios
                                        , vCampo10_precios
                                    FROM tbl_precios 
                                    WHERE tbl_precios.b_status > 0 "
            );

            IF(b_filtro_like=true) THEN BEGIN

                SET @_QUERY:=CONCAT(@_QUERY, " AND (vCampo1_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo2_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo3_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo4_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo5_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo6_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo7_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo8_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo9_precios LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo10_precios LIKE '%",TRIM(vc_string_filtro),"%')");

            END; END IF;

            IF(i_colum_order IS NOT NULL) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
            END; END IF;

            IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
            END; END IF;

            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

            SELECT COUNT(*) INTO v_registro_total FROM tbl_precios WHERE b_status > 0;
        END ;;
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_get_precios_by_id`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_precios_by_id`(IN `v_id_precios` BIGINT(20))
      READS SQL DATA DETERMINISTIC
      BEGIN
          SELECT id_precios AS id
          , vCampo1_precios
          , vCampo2_precios
          , vCampo3_precios
          , vCampo4_precios
          , vCampo5_precios 
          , vCampo6_precios 
          , vCampo7_precios 
          , vCampo8_precios 
          , vCampo9_precios 
          , vCampo10_precios 
          , vCampo11_precios 
          , vCampo12_precios 
          , vCampo13_precios 
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
          FROM tbl_precios
          WHERE id_precios= v_id_precios AND b_status > 0
          LIMIT 1 ;  
      END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_set_precios`;
DELIMITER ;;
CREATE PROCEDURE `sp_set_precios`(
    IN `v_vCampo1_precios` VARCHAR(200)
  , IN `v_vCampo2_precios` VARCHAR(210)
  , IN `v_vCampo3_precios` VARCHAR(220)
  , IN `v_vCampo4_precios` VARCHAR(230)
  , IN `v_vCampo5_precios` VARCHAR(240)
  , IN `v_vCampo6_precios` VARCHAR(250)
  , IN `v_vCampo7_precios` VARCHAR(260)
  , IN `v_vCampo8_precios` VARCHAR(270)
  , IN `v_vCampo9_precios` VARCHAR(280)
  , IN `v_vCampo10_precios` VARCHAR(290)
  , IN `v_vCampo11_precios` VARCHAR(300)
  , IN `v_vCampo12_precios` VARCHAR(310)
  , IN `v_vCampo13_precios` VARCHAR(320)
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

            INSERT INTO tbl_precios(  
              vCampo1_precios
              , vCampo2_precios
              , vCampo3_precios
              , vCampo4_precios
              , vCampo5_precios
              , vCampo6_precios
              , vCampo7_precios
              , vCampo8_precios
              , vCampo9_precios
              , vCampo10_precios
              , vCampo11_precios
              , vCampo12_precios
              , vCampo13_precios
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
            SELECT  v_vCampo1_precios
            , v_vCampo2_precios
            , v_vCampo3_precios
            , v_vCampo4_precios
            , v_vCampo5_precios
            , v_vCampo6_precios
            , v_vCampo7_precios
            , v_vCampo8_precios
            , v_vCampo9_precios
            , v_vCampo10_precios
            , v_vCampo11_precios
            , v_vCampo12_precios
            , v_vCampo13_precios
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
CREATE PROCEDURE `sp_set_importar_precios`(IN `v_id_precios` BIGINT(20)
  , IN `v_vCampo1_precios` VARCHAR(200)
  , IN `v_vCampo2_precios` VARCHAR(210)
  , IN `v_vCampo3_precios` VARCHAR(220)
  , IN `v_vCampo4_precios` VARCHAR(230)
  , IN `v_vCampo5_precios` VARCHAR(240)
  , IN `v_vCampo6_precios` VARCHAR(250)
  , IN `v_vCampo7_precios` VARCHAR(260)
  , IN `v_vCampo8_precios` VARCHAR(270)
  , IN `v_vCampo9_precios` VARCHAR(280)
  , IN `v_vCampo10_precios` VARCHAR(290)
  , IN `v_vCampo11_precios` VARCHAR(300)
  , IN `v_vCampo12_precios` VARCHAR(310)
  , IN `v_vCampo13_precios` VARCHAR(320)
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
        FROM tbl_precios 
        WHERE id_precios= v_id_precios AND b_status > 0 LIMIT 1 ;

        IF (v_b_exists > 0) THEN BEGIN
            UPDATE tbl_precios 
            SET vCampo1_precios   = v_vCampo1_precios
              , vCampo2_precios   = v_vCampo2_precios
              , vCampo3_precios   = v_vCampo3_precios
              , vCampo4_precios   = v_vCampo4_precios
              , vCampo5_precios   = v_vCampo5_precios
              , vCampo6_precios   = v_vCampo6_precios
              , vCampo7_precios   = v_vCampo7_precios
              , vCampo8_precios   = v_vCampo8_precios
              , vCampo9_precios   = v_vCampo9_precios
              , vCampo10_precios   = v_vCampo10_precios
              , vCampo11_precios   = v_vCampo11_precios
              , vCampo12_precios   = v_vCampo12_precios
              , vCampo13_precios   = v_vCampo13_precios
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
            WHERE id_precios= v_id_precios ;
            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

        IF (v_b_exists = 0) THEN BEGIN
            INSERT INTO tbl_precios(  
              vCampo1_precios
              , vCampo2_precios
              , vCampo3_precios
              , vCampo4_precios
              , vCampo5_precios
              , vCampo6_precios
              , vCampo7_precios
              , vCampo8_precios
              , vCampo9_precios
              , vCampo10_precios
              , vCampo11_precios
              , vCampo12_precios
              , vCampo13_precios
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
            SELECT  v_vCampo1_precios
            , v_vCampo2_precios
            , v_vCampo3_precios
            , v_vCampo4_precios
            , v_vCampo5_precios
            , v_vCampo6_precios
            , v_vCampo7_precios
            , v_vCampo8_precios
            , v_vCampo9_precios
            , v_vCampo10_precios
            , v_vCampo11_precios
            , v_vCampo12_precios
            , v_vCampo13_precios
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
CREATE PROCEDURE `sp_set_update_precios`(IN `v_id_precios` BIGINT(20)
  , IN `v_vCampo1_precios` VARCHAR(200)
  , IN `v_vCampo2_precios` VARCHAR(210)
  , IN `v_vCampo3_precios` VARCHAR(220)
  , IN `v_vCampo4_precios` VARCHAR(230)
  , IN `v_vCampo5_precios` VARCHAR(240)
  , IN `v_vCampo6_precios` VARCHAR(250)
  , IN `v_vCampo7_precios` VARCHAR(260)
  , IN `v_vCampo8_precios` VARCHAR(270)
  , IN `v_vCampo9_precios` VARCHAR(280)
  , IN `v_vCampo10_precios` VARCHAR(290)
  , IN `v_vCampo11_precios` VARCHAR(300)
  , IN `v_vCampo12_precios` VARCHAR(310)
  , IN `v_vCampo13_precios` VARCHAR(320)
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

  UPDATE tbl_precios 
  SET vCampo1_precios   = v_vCampo1_precios
    , vCampo2_precios   = v_vCampo2_precios
    , vCampo3_precios   = v_vCampo3_precios
    , vCampo4_precios   = v_vCampo4_precios
    , vCampo5_precios   = v_vCampo5_precios
    , vCampo6_precios   = v_vCampo6_precios
    , vCampo7_precios   = v_vCampo7_precios
    , vCampo8_precios   = v_vCampo8_precios
    , vCampo9_precios   = v_vCampo9_precios
    , vCampo10_precios   = v_vCampo10_precios
    , vCampo11_precios   = v_vCampo11_precios
    , vCampo12_precios   = v_vCampo12_precios
    , vCampo13_precios   = v_vCampo13_precios
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
  WHERE id_precios= v_id_precios ;
  SET v_i_response := LAST_INSERT_ID();

END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_undo_delete_precios`;
DELIMITER ;;
    CREATE PROCEDURE `sp_undo_delete_precios`(IN `v_id_precios` BIGINT(20), OUT `v_i_internal_status` INTEGER)
    MODIFIES SQL DATA
    BEGIN
        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        UPDATE tbl_precios SET b_status= 1
        WHERE id_precios= v_id_precios;
        SET v_i_internal_status:= ROW_COUNT();

    END ;;
DELIMITER ;

