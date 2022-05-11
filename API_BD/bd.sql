DROP TABLE IF EXISTS `tbl_%name_strtolower%`;
CREATE TABLE `tbl_%name_strtolower%` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vCampo1_%name_strtolower%` varchar(200) NOT NULL DEFAULT '',
  `vCampo2_%name_strtolower%` varchar(210) NOT NULL DEFAULT '',
  `vCampo3_%name_strtolower%` varchar(220) NOT NULL DEFAULT '',
  `vCampo4_%name_strtolower%` varchar(230) NOT NULL DEFAULT '',
  `vCampo5_%name_strtolower%` varchar(240) NOT NULL DEFAULT '',
  `vCampo6_%name_strtolower%` varchar(250) NOT NULL DEFAULT '',
  `vCampo7_%name_strtolower%` varchar(260) NOT NULL DEFAULT '',
  `vCampo8_%name_strtolower%` varchar(270) NOT NULL DEFAULT '',
  `vCampo9_%name_strtolower%` varchar(280) NOT NULL DEFAULT '',
  `vCampo10_%name_strtolower%` varchar(290) NOT NULL DEFAULT '',
  `vCampo11_%name_strtolower%` varchar(300) NOT NULL DEFAULT '',
  `vCampo12_%name_strtolower%` varchar(310) NOT NULL DEFAULT '',
  `vCampo13_%name_strtolower%` varchar(320) NOT NULL DEFAULT '',
  `vCampo14_%name_strtolower%` varchar(330) NOT NULL DEFAULT '',
  `vCampo15_%name_strtolower%` varchar(340) NOT NULL DEFAULT '',
  `vCampo16_%name_strtolower%` varchar(350) NOT NULL DEFAULT '',
  `vCampo17_%name_strtolower%` varchar(360) NOT NULL DEFAULT '',
  `vCampo18_%name_strtolower%` varchar(370) NOT NULL DEFAULT '',
  `vCampo19_%name_strtolower%` varchar(380) NOT NULL DEFAULT '',
  `vCampo20_%name_strtolower%` varchar(390) NOT NULL DEFAULT '',
  `vCampo21_%name_strtolower%` varchar(400) NOT NULL DEFAULT '',
  `vCampo22_%name_strtolower%` varchar(410) NOT NULL DEFAULT '',
  `vCampo23_%name_strtolower%` varchar(420) NOT NULL DEFAULT '',
  `vCampo24_%name_strtolower%` varchar(430) NOT NULL DEFAULT '',
  `vCampo25_%name_strtolower%` varchar(440) NOT NULL DEFAULT '',
  `vCampo26_%name_strtolower%` varchar(450) NOT NULL DEFAULT '',
  `vCampo27_%name_strtolower%` varchar(460) NOT NULL DEFAULT '',
  `vCampo28_%name_strtolower%` varchar(470) NOT NULL DEFAULT '',
  `vCampo29_%name_strtolower%` varchar(480) NOT NULL DEFAULT '',
  `vCampo30_%name_strtolower%` varchar(490) NOT NULL DEFAULT '',
  `dt_last_change` TIMESTAMP DEFAULT 0 ON UPDATE CURRENT_TIMESTAMP,
  `dt_request` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `b_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP PROCEDURE IF EXISTS `sp_delete_%name_strtolower%`;
DELIMITER ;;
    CREATE PROCEDURE `sp_delete_%name_strtolower%`(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
        MODIFIES SQL DATA
    BEGIN

        UPDATE tbl_%name_strtolower%  SET b_status= 0
        WHERE id= v_id;
        SET v_i_internal_status:= ROW_COUNT();
    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_get_%name_strtolower%`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_%name_strtolower%`( b_filtro_like bool
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
                                WHEN i_colum_order=1 THEN CONCAT("  ORDER BY vCampo1_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=2 THEN CONCAT("  ORDER BY vCampo2_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=3 THEN CONCAT("  ORDER BY vCampo3_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=4 THEN CONCAT("  ORDER BY vCampo4_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=5 THEN CONCAT("  ORDER BY vCampo5_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=6 THEN CONCAT("  ORDER BY vCampo6_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=7 THEN CONCAT("  ORDER BY vCampo7_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=8 THEN CONCAT("  ORDER BY vCampo8_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=9 THEN CONCAT("  ORDER BY vCampo9_%name_strtolower% ",vc_order_direct)
                                WHEN i_colum_order=10 THEN CONCAT(" ORDER BY vCampo10_%name_strtolower% ",vc_order_direct)
                                ELSE ""
            END;

            SET @_QUERY:=CONCAT("SELECT   id AS id
                                        , vCampo1_%name_strtolower%
                                        , vCampo2_%name_strtolower%
                                        , vCampo3_%name_strtolower%
                                        , vCampo4_%name_strtolower%
                                        , vCampo5_%name_strtolower%
                                        , vCampo6_%name_strtolower%
                                        , vCampo7_%name_strtolower%
                                        , vCampo8_%name_strtolower%
                                        , vCampo9_%name_strtolower%
                                        , vCampo10_%name_strtolower%
                                    FROM tbl_%name_strtolower% 
                                    WHERE tbl_%name_strtolower%.b_status > 0 "
            );

            IF(b_filtro_like=true) THEN BEGIN

                SET @_QUERY:=CONCAT(@_QUERY, " AND (vCampo1_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo2_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo3_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo4_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo5_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo6_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo7_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo8_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo9_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  vCampo10_%name_strtolower% LIKE '%",TRIM(vc_string_filtro),"%')");

            END; END IF;

            IF(i_colum_order IS NOT NULL) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
            END; END IF;

            IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
            END; END IF;

            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

            SELECT COUNT(*) INTO v_registro_total FROM tbl_%name_strtolower% WHERE b_status > 0;
        END ;;
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_get_%name_strtolower%_by_id`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_%name_strtolower%_by_id`(IN `v_id` BIGINT(20))
      READS SQL DATA DETERMINISTIC
      BEGIN
          SELECT id AS id
          , vCampo1_%name_strtolower%
          , vCampo2_%name_strtolower%
          , vCampo3_%name_strtolower%
          , vCampo4_%name_strtolower%
          , vCampo5_%name_strtolower% 
          , vCampo6_%name_strtolower% 
          , vCampo7_%name_strtolower% 
          , vCampo8_%name_strtolower% 
          , vCampo9_%name_strtolower% 
          , vCampo10_%name_strtolower% 
          , vCampo11_%name_strtolower% 
          , vCampo12_%name_strtolower% 
          , vCampo13_%name_strtolower% 
          , vCampo14_%name_strtolower% 
          , vCampo15_%name_strtolower% 
          , vCampo16_%name_strtolower% 
          , vCampo17_%name_strtolower% 
          , vCampo18_%name_strtolower% 
          , vCampo19_%name_strtolower% 
          , vCampo20_%name_strtolower% 
          , vCampo21_%name_strtolower% 
          , vCampo22_%name_strtolower% 
          , vCampo23_%name_strtolower% 
          , vCampo24_%name_strtolower% 
          , vCampo25_%name_strtolower% 
          , vCampo26_%name_strtolower% 
          , vCampo27_%name_strtolower% 
          , vCampo28_%name_strtolower% 
          , vCampo29_%name_strtolower% 
          , vCampo30_%name_strtolower% 
          FROM tbl_%name_strtolower%
          WHERE id= v_id AND b_status > 0
          LIMIT 1 ;  
      END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_set_%name_strtolower%`;
DELIMITER ;;
CREATE PROCEDURE `sp_set_%name_strtolower%`(
    IN `v_vCampo1_%name_strtolower%` VARCHAR(200)
  , IN `v_vCampo2_%name_strtolower%` VARCHAR(210)
  , IN `v_vCampo3_%name_strtolower%` VARCHAR(220)
  , IN `v_vCampo4_%name_strtolower%` VARCHAR(230)
  , IN `v_vCampo5_%name_strtolower%` VARCHAR(240)
  , IN `v_vCampo6_%name_strtolower%` VARCHAR(250)
  , IN `v_vCampo7_%name_strtolower%` VARCHAR(260)
  , IN `v_vCampo8_%name_strtolower%` VARCHAR(270)
  , IN `v_vCampo9_%name_strtolower%` VARCHAR(280)
  , IN `v_vCampo10_%name_strtolower%` VARCHAR(290)
  , IN `v_vCampo11_%name_strtolower%` VARCHAR(300)
  , IN `v_vCampo12_%name_strtolower%` VARCHAR(310)
  , IN `v_vCampo13_%name_strtolower%` VARCHAR(320)
  , IN `v_vCampo14_%name_strtolower%` VARCHAR(330)
  , IN `v_vCampo15_%name_strtolower%` VARCHAR(340)
  , IN `v_vCampo16_%name_strtolower%` VARCHAR(350)
  , IN `v_vCampo17_%name_strtolower%` VARCHAR(360)
  , IN `v_vCampo18_%name_strtolower%` VARCHAR(370)
  , IN `v_vCampo19_%name_strtolower%` VARCHAR(380)
  , IN `v_vCampo20_%name_strtolower%` VARCHAR(390)
  , IN `v_vCampo21_%name_strtolower%` VARCHAR(400)
  , IN `v_vCampo22_%name_strtolower%` VARCHAR(410)
  , IN `v_vCampo23_%name_strtolower%` VARCHAR(420)
  , IN `v_vCampo24_%name_strtolower%` VARCHAR(430)
  , IN `v_vCampo25_%name_strtolower%` VARCHAR(440)
  , IN `v_vCampo26_%name_strtolower%` VARCHAR(450)
  , IN `v_vCampo27_%name_strtolower%` VARCHAR(460)
  , IN `v_vCampo28_%name_strtolower%` VARCHAR(470)
  , IN `v_vCampo29_%name_strtolower%` VARCHAR(480)
  , IN `v_vCampo30_%name_strtolower%` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
        BEGIN

            DECLARE v_b_exists INTEGER(1) ;

            SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

            INSERT INTO tbl_%name_strtolower%(  
              vCampo1_%name_strtolower%
              , vCampo2_%name_strtolower%
              , vCampo3_%name_strtolower%
              , vCampo4_%name_strtolower%
              , vCampo5_%name_strtolower%
              , vCampo6_%name_strtolower%
              , vCampo7_%name_strtolower%
              , vCampo8_%name_strtolower%
              , vCampo9_%name_strtolower%
              , vCampo10_%name_strtolower%
              , vCampo11_%name_strtolower%
              , vCampo12_%name_strtolower%
              , vCampo13_%name_strtolower%
              , vCampo14_%name_strtolower%
              , vCampo15_%name_strtolower%
              , vCampo16_%name_strtolower%
              , vCampo17_%name_strtolower%
              , vCampo18_%name_strtolower%
              , vCampo19_%name_strtolower%
              , vCampo20_%name_strtolower%
              , vCampo21_%name_strtolower%
              , vCampo22_%name_strtolower%
              , vCampo23_%name_strtolower%
              , vCampo24_%name_strtolower%
              , vCampo25_%name_strtolower%
              , vCampo26_%name_strtolower%
              , vCampo27_%name_strtolower%
              , vCampo28_%name_strtolower%
              , vCampo29_%name_strtolower%
              , vCampo30_%name_strtolower%
            )
            SELECT  v_vCampo1_%name_strtolower%
            , v_vCampo2_%name_strtolower%
            , v_vCampo3_%name_strtolower%
            , v_vCampo4_%name_strtolower%
            , v_vCampo5_%name_strtolower%
            , v_vCampo6_%name_strtolower%
            , v_vCampo7_%name_strtolower%
            , v_vCampo8_%name_strtolower%
            , v_vCampo9_%name_strtolower%
            , v_vCampo10_%name_strtolower%
            , v_vCampo11_%name_strtolower%
            , v_vCampo12_%name_strtolower%
            , v_vCampo13_%name_strtolower%
            , v_vCampo14_%name_strtolower%
            , v_vCampo15_%name_strtolower%
            , v_vCampo16_%name_strtolower%
            , v_vCampo17_%name_strtolower%
            , v_vCampo18_%name_strtolower%
            , v_vCampo19_%name_strtolower%
            , v_vCampo20_%name_strtolower%
            , v_vCampo21_%name_strtolower%
            , v_vCampo22_%name_strtolower%
            , v_vCampo23_%name_strtolower%
            , v_vCampo24_%name_strtolower%
            , v_vCampo25_%name_strtolower%
            , v_vCampo26_%name_strtolower%
            , v_vCampo27_%name_strtolower%
            , v_vCampo28_%name_strtolower%
            , v_vCampo29_%name_strtolower%
            , v_vCampo30_%name_strtolower%

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_importar_%name_strtolower%`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_importar_%name_strtolower%`(IN `v_id` BIGINT(20)
  , IN `v_vCampo1_%name_strtolower%` VARCHAR(200)
  , IN `v_vCampo2_%name_strtolower%` VARCHAR(210)
  , IN `v_vCampo3_%name_strtolower%` VARCHAR(220)
  , IN `v_vCampo4_%name_strtolower%` VARCHAR(230)
  , IN `v_vCampo5_%name_strtolower%` VARCHAR(240)
  , IN `v_vCampo6_%name_strtolower%` VARCHAR(250)
  , IN `v_vCampo7_%name_strtolower%` VARCHAR(260)
  , IN `v_vCampo8_%name_strtolower%` VARCHAR(270)
  , IN `v_vCampo9_%name_strtolower%` VARCHAR(280)
  , IN `v_vCampo10_%name_strtolower%` VARCHAR(290)
  , IN `v_vCampo11_%name_strtolower%` VARCHAR(300)
  , IN `v_vCampo12_%name_strtolower%` VARCHAR(310)
  , IN `v_vCampo13_%name_strtolower%` VARCHAR(320)
  , IN `v_vCampo14_%name_strtolower%` VARCHAR(330)
  , IN `v_vCampo15_%name_strtolower%` VARCHAR(340)
  , IN `v_vCampo16_%name_strtolower%` VARCHAR(350)
  , IN `v_vCampo17_%name_strtolower%` VARCHAR(360)
  , IN `v_vCampo18_%name_strtolower%` VARCHAR(370)
  , IN `v_vCampo19_%name_strtolower%` VARCHAR(380)
  , IN `v_vCampo20_%name_strtolower%` VARCHAR(390)
  , IN `v_vCampo21_%name_strtolower%` VARCHAR(400)
  , IN `v_vCampo22_%name_strtolower%` VARCHAR(410)
  , IN `v_vCampo23_%name_strtolower%` VARCHAR(420)
  , IN `v_vCampo24_%name_strtolower%` VARCHAR(430)
  , IN `v_vCampo25_%name_strtolower%` VARCHAR(440)
  , IN `v_vCampo26_%name_strtolower%` VARCHAR(450)
  , IN `v_vCampo27_%name_strtolower%` VARCHAR(460)
  , IN `v_vCampo28_%name_strtolower%` VARCHAR(470)
  , IN `v_vCampo29_%name_strtolower%` VARCHAR(480)
  , IN `v_vCampo30_%name_strtolower%` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
    BEGIN

        DECLARE v_b_exists INTEGER(1) ;

        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        SELECT COUNT(*) INTO v_b_exists 
        FROM tbl_%name_strtolower% 
        WHERE id= v_id AND b_status > 0 LIMIT 1 ;

        IF (v_b_exists > 0) THEN BEGIN
            UPDATE tbl_%name_strtolower% 
            SET vCampo1_%name_strtolower%   = v_vCampo1_%name_strtolower%
              , vCampo2_%name_strtolower%   = v_vCampo2_%name_strtolower%
              , vCampo3_%name_strtolower%   = v_vCampo3_%name_strtolower%
              , vCampo4_%name_strtolower%   = v_vCampo4_%name_strtolower%
              , vCampo5_%name_strtolower%   = v_vCampo5_%name_strtolower%
              , vCampo6_%name_strtolower%   = v_vCampo6_%name_strtolower%
              , vCampo7_%name_strtolower%   = v_vCampo7_%name_strtolower%
              , vCampo8_%name_strtolower%   = v_vCampo8_%name_strtolower%
              , vCampo9_%name_strtolower%   = v_vCampo9_%name_strtolower%
              , vCampo10_%name_strtolower%   = v_vCampo10_%name_strtolower%
              , vCampo11_%name_strtolower%   = v_vCampo11_%name_strtolower%
              , vCampo12_%name_strtolower%   = v_vCampo12_%name_strtolower%
              , vCampo13_%name_strtolower%   = v_vCampo13_%name_strtolower%
              , vCampo14_%name_strtolower%   = v_vCampo14_%name_strtolower%
              , vCampo15_%name_strtolower%   = v_vCampo15_%name_strtolower%
              , vCampo16_%name_strtolower%   = v_vCampo16_%name_strtolower%
              , vCampo17_%name_strtolower%   = v_vCampo17_%name_strtolower%
              , vCampo18_%name_strtolower%   = v_vCampo18_%name_strtolower%
              , vCampo19_%name_strtolower%   = v_vCampo19_%name_strtolower%
              , vCampo20_%name_strtolower%   = v_vCampo20_%name_strtolower%
              , vCampo21_%name_strtolower%   = v_vCampo21_%name_strtolower%
              , vCampo22_%name_strtolower%   = v_vCampo22_%name_strtolower%
              , vCampo23_%name_strtolower%   = v_vCampo23_%name_strtolower%
              , vCampo24_%name_strtolower%   = v_vCampo24_%name_strtolower%
              , vCampo25_%name_strtolower%   = v_vCampo25_%name_strtolower%
              , vCampo26_%name_strtolower%   = v_vCampo26_%name_strtolower%
              , vCampo27_%name_strtolower%   = v_vCampo27_%name_strtolower%
              , vCampo28_%name_strtolower%   = v_vCampo28_%name_strtolower%
              , vCampo29_%name_strtolower%   = v_vCampo29_%name_strtolower%
              , vCampo30_%name_strtolower%   = v_vCampo30_%name_strtolower%
            WHERE id= v_id ;
            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

        IF (v_b_exists = 0) THEN BEGIN
            INSERT INTO tbl_%name_strtolower%(  
              vCampo1_%name_strtolower%
              , vCampo2_%name_strtolower%
              , vCampo3_%name_strtolower%
              , vCampo4_%name_strtolower%
              , vCampo5_%name_strtolower%
              , vCampo6_%name_strtolower%
              , vCampo7_%name_strtolower%
              , vCampo8_%name_strtolower%
              , vCampo9_%name_strtolower%
              , vCampo10_%name_strtolower%
              , vCampo11_%name_strtolower%
              , vCampo12_%name_strtolower%
              , vCampo13_%name_strtolower%
              , vCampo14_%name_strtolower%
              , vCampo15_%name_strtolower%
              , vCampo16_%name_strtolower%
              , vCampo17_%name_strtolower%
              , vCampo18_%name_strtolower%
              , vCampo19_%name_strtolower%
              , vCampo20_%name_strtolower%
              , vCampo21_%name_strtolower%
              , vCampo22_%name_strtolower%
              , vCampo23_%name_strtolower%
              , vCampo24_%name_strtolower%
              , vCampo25_%name_strtolower%
              , vCampo26_%name_strtolower%
              , vCampo27_%name_strtolower%
              , vCampo28_%name_strtolower%
              , vCampo29_%name_strtolower%
              , vCampo30_%name_strtolower%
            )
            SELECT  v_vCampo1_%name_strtolower%
            , v_vCampo2_%name_strtolower%
            , v_vCampo3_%name_strtolower%
            , v_vCampo4_%name_strtolower%
            , v_vCampo5_%name_strtolower%
            , v_vCampo6_%name_strtolower%
            , v_vCampo7_%name_strtolower%
            , v_vCampo8_%name_strtolower%
            , v_vCampo9_%name_strtolower%
            , v_vCampo10_%name_strtolower%
            , v_vCampo11_%name_strtolower%
            , v_vCampo12_%name_strtolower%
            , v_vCampo13_%name_strtolower%
            , v_vCampo14_%name_strtolower%
            , v_vCampo15_%name_strtolower%
            , v_vCampo16_%name_strtolower%
            , v_vCampo17_%name_strtolower%
            , v_vCampo18_%name_strtolower%
            , v_vCampo19_%name_strtolower%
            , v_vCampo20_%name_strtolower%
            , v_vCampo21_%name_strtolower%
            , v_vCampo22_%name_strtolower%
            , v_vCampo23_%name_strtolower%
            , v_vCampo24_%name_strtolower%
            , v_vCampo25_%name_strtolower%
            , v_vCampo26_%name_strtolower%
            , v_vCampo27_%name_strtolower%
            , v_vCampo28_%name_strtolower%
            , v_vCampo29_%name_strtolower%
            , v_vCampo30_%name_strtolower%

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_update_%name_strtolower%`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_update_%name_strtolower%`(IN `v_id` BIGINT(20)
  , IN `v_vCampo1_%name_strtolower%` VARCHAR(200)
  , IN `v_vCampo2_%name_strtolower%` VARCHAR(210)
  , IN `v_vCampo3_%name_strtolower%` VARCHAR(220)
  , IN `v_vCampo4_%name_strtolower%` VARCHAR(230)
  , IN `v_vCampo5_%name_strtolower%` VARCHAR(240)
  , IN `v_vCampo6_%name_strtolower%` VARCHAR(250)
  , IN `v_vCampo7_%name_strtolower%` VARCHAR(260)
  , IN `v_vCampo8_%name_strtolower%` VARCHAR(270)
  , IN `v_vCampo9_%name_strtolower%` VARCHAR(280)
  , IN `v_vCampo10_%name_strtolower%` VARCHAR(290)
  , IN `v_vCampo11_%name_strtolower%` VARCHAR(300)
  , IN `v_vCampo12_%name_strtolower%` VARCHAR(310)
  , IN `v_vCampo13_%name_strtolower%` VARCHAR(320)
  , IN `v_vCampo14_%name_strtolower%` VARCHAR(330)
  , IN `v_vCampo15_%name_strtolower%` VARCHAR(340)
  , IN `v_vCampo16_%name_strtolower%` VARCHAR(350)
  , IN `v_vCampo17_%name_strtolower%` VARCHAR(360)
  , IN `v_vCampo18_%name_strtolower%` VARCHAR(370)
  , IN `v_vCampo19_%name_strtolower%` VARCHAR(380)
  , IN `v_vCampo20_%name_strtolower%` VARCHAR(390)
  , IN `v_vCampo21_%name_strtolower%` VARCHAR(400)
  , IN `v_vCampo22_%name_strtolower%` VARCHAR(410)
  , IN `v_vCampo23_%name_strtolower%` VARCHAR(420)
  , IN `v_vCampo24_%name_strtolower%` VARCHAR(430)
  , IN `v_vCampo25_%name_strtolower%` VARCHAR(440)
  , IN `v_vCampo26_%name_strtolower%` VARCHAR(450)
  , IN `v_vCampo27_%name_strtolower%` VARCHAR(460)
  , IN `v_vCampo28_%name_strtolower%` VARCHAR(470)
  , IN `v_vCampo29_%name_strtolower%` VARCHAR(480)
  , IN `v_vCampo30_%name_strtolower%` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
BEGIN

  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

  UPDATE tbl_%name_strtolower% 
  SET vCampo1_%name_strtolower%   = v_vCampo1_%name_strtolower%
    , vCampo2_%name_strtolower%   = v_vCampo2_%name_strtolower%
    , vCampo3_%name_strtolower%   = v_vCampo3_%name_strtolower%
    , vCampo4_%name_strtolower%   = v_vCampo4_%name_strtolower%
    , vCampo5_%name_strtolower%   = v_vCampo5_%name_strtolower%
    , vCampo6_%name_strtolower%   = v_vCampo6_%name_strtolower%
    , vCampo7_%name_strtolower%   = v_vCampo7_%name_strtolower%
    , vCampo8_%name_strtolower%   = v_vCampo8_%name_strtolower%
    , vCampo9_%name_strtolower%   = v_vCampo9_%name_strtolower%
    , vCampo10_%name_strtolower%   = v_vCampo10_%name_strtolower%
    , vCampo11_%name_strtolower%   = v_vCampo11_%name_strtolower%
    , vCampo12_%name_strtolower%   = v_vCampo12_%name_strtolower%
    , vCampo13_%name_strtolower%   = v_vCampo13_%name_strtolower%
    , vCampo14_%name_strtolower%   = v_vCampo14_%name_strtolower%
    , vCampo15_%name_strtolower%   = v_vCampo15_%name_strtolower%
    , vCampo16_%name_strtolower%   = v_vCampo16_%name_strtolower%
    , vCampo17_%name_strtolower%   = v_vCampo17_%name_strtolower%
    , vCampo18_%name_strtolower%   = v_vCampo18_%name_strtolower%
    , vCampo19_%name_strtolower%   = v_vCampo19_%name_strtolower%
    , vCampo20_%name_strtolower%   = v_vCampo20_%name_strtolower%
    , vCampo21_%name_strtolower%   = v_vCampo21_%name_strtolower%
    , vCampo22_%name_strtolower%   = v_vCampo22_%name_strtolower%
    , vCampo23_%name_strtolower%   = v_vCampo23_%name_strtolower%
    , vCampo24_%name_strtolower%   = v_vCampo24_%name_strtolower%
    , vCampo25_%name_strtolower%   = v_vCampo25_%name_strtolower%
    , vCampo26_%name_strtolower%   = v_vCampo26_%name_strtolower%
    , vCampo27_%name_strtolower%   = v_vCampo27_%name_strtolower%
    , vCampo28_%name_strtolower%   = v_vCampo28_%name_strtolower%
    , vCampo29_%name_strtolower%   = v_vCampo29_%name_strtolower%
    , vCampo30_%name_strtolower%   = v_vCampo30_%name_strtolower%
  WHERE id= v_id ;
  SET v_i_response := LAST_INSERT_ID();

END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_undo_delete_%name_strtolower%`;
DELIMITER ;;
    CREATE PROCEDURE `sp_undo_delete_%name_strtolower%`(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
    MODIFIES SQL DATA
    BEGIN
        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        UPDATE tbl_%name_strtolower% SET b_status= 1
        WHERE id= v_id;
        SET v_i_internal_status:= ROW_COUNT();

    END ;;
DELIMITER ;

