DROP PROCEDURE IF EXISTS `sp_delete_cuenta_movimientos`;
DELIMITER ;;
    CREATE PROCEDURE `sp_delete_cuenta_movimientos`(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
        MODIFIES SQL DATA
    BEGIN

        UPDATE cuenta_movimientos  SET activo= 0
        WHERE id= v_id;
        SET v_i_internal_status:= ROW_COUNT();
    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_get_cuenta_movimientos`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_cuenta_movimientos`( b_filtro_like bool
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
                                WHEN i_colum_order=1 THEN CONCAT("  ORDER BY id_cliente ",vc_order_direct)
                                WHEN i_colum_order=2 THEN CONCAT("  ORDER BY id_paypal ",vc_order_direct)
                                WHEN i_colum_order=3 THEN CONCAT("  ORDER BY id_movimiento ",vc_order_direct)
                                WHEN i_colum_order=4 THEN CONCAT("  ORDER BY tipo_movimiento ",vc_order_direct)
                                WHEN i_colum_order=5 THEN CONCAT("  ORDER BY saldo_anterior ",vc_order_direct)
                                WHEN i_colum_order=6 THEN CONCAT("  ORDER BY saldo_nuevo ",vc_order_direct)
                                WHEN i_colum_order=7 THEN CONCAT("  ORDER BY importe ",vc_order_direct)
                                WHEN i_colum_order=8 THEN CONCAT("  ORDER BY monto_total ",vc_order_direct)
                                WHEN i_colum_order=9 THEN CONCAT("  ORDER BY titular_cuenta ",vc_order_direct)
                                WHEN i_colum_order=10 THEN CONCAT(" ORDER BY refvc ",vc_order_direct)
                                ELSE ""
            END;

            SET @_QUERY:=CONCAT("SELECT   id AS id
                                        , id_cliente
                                        , id_paypal
                                        , id_movimiento
                                        , tipo_movimiento
                                        , saldo_anterior
                                        , saldo_nuevo
                                        , importe
                                        , monto_total
                                        , titular_cuenta
                                        , refvc
                                    FROM cuenta_movimientos 
                                    WHERE cuenta_movimientos.activo > 0 "
            );

            IF(b_filtro_like=true) THEN BEGIN

                SET @_QUERY:=CONCAT(@_QUERY, " AND (id_cliente LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  id_paypal LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  id_movimiento LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  tipo_movimiento LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  saldo_anterior LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  saldo_nuevo LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  importe LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  monto_total LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  titular_cuenta LIKE '%",TRIM(vc_string_filtro),"%'");
                SET @_QUERY:=CONCAT(@_QUERY, " OR  refvc LIKE '%",TRIM(vc_string_filtro),"%')");

            END; END IF;

            IF(i_colum_order IS NOT NULL) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY,vc_column_order);
            END; END IF;

            IF(i_limit_init >= 0 AND i_limit_end > 0 ) THEN BEGIN
                SET @_QUERY:=CONCAT(@_QUERY, " LIMIT ",i_limit_init,",",i_limit_end);
            END; END IF;

            PREPARE QRY FROM @_QUERY; EXECUTE QRY ; DEALLOCATE PREPARE QRY ;

            SELECT COUNT(*) INTO v_registro_total FROM cuenta_movimientos WHERE activo > 0;
        END ;;
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_get_cuenta_movimientos_by_id`;
DELIMITER ;;
    CREATE PROCEDURE `sp_get_cuenta_movimientos_by_id`(IN `v_id` BIGINT(20))
      READS SQL DATA DETERMINISTIC
      BEGIN
          SELECT id AS id
          , id_cliente
          , id_paypal
          , id_movimiento
          , tipo_movimiento
          , saldo_anterior 
          , saldo_nuevo 
          , importe 
          , monto_total 
          , titular_cuenta 
          , refvc 
          , id_concepto 
          , descripcion 
          , fecha_movimiento 
          , creado_por 
          , refInt 
          , refInt2 
          , modificado 
          , activo 
          , id_cuenta_movimientos 
          , id_cliente 
          , id_paypal 
          , id_movimiento 
          , tipo_movimiento 
          , saldo_anterior 
          , saldo_nuevo 
          , importe 
          , titular_cuenta 
          , refvc 
          , id_concepto 
          , descripcion 
          FROM cuenta_movimientos
          WHERE id= v_id AND activo > 0
          LIMIT 1 ;  
      END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_set_cuenta_movimientos`;
DELIMITER ;;
CREATE PROCEDURE `sp_set_cuenta_movimientos`(
    IN `v_id_cliente` VARCHAR(200)
  , IN `v_id_paypal` VARCHAR(210)
  , IN `v_id_movimiento` VARCHAR(220)
  , IN `v_tipo_movimiento` VARCHAR(230)
  , IN `v_saldo_anterior` VARCHAR(240)
  , IN `v_saldo_nuevo` VARCHAR(250)
  , IN `v_importe` VARCHAR(260)
  , IN `v_monto_total` VARCHAR(270)
  , IN `v_titular_cuenta` VARCHAR(280)
  , IN `v_refvc` VARCHAR(290)
  , IN `v_id_concepto` VARCHAR(300)
  , IN `v_descripcion` VARCHAR(310)
  , IN `v_fecha_movimiento` VARCHAR(320)
  , IN `v_creado_por` VARCHAR(330)
  , IN `v_refInt` VARCHAR(340)
  , IN `v_refInt2` VARCHAR(350)
  , IN `v_modificado` VARCHAR(360)
  , IN `v_activo` VARCHAR(370)
  , IN `v_id_cuenta_movimientos` VARCHAR(380)
  , IN `v_id_cliente` VARCHAR(390)
  , IN `v_id_paypal` VARCHAR(400)
  , IN `v_id_movimiento` VARCHAR(410)
  , IN `v_tipo_movimiento` VARCHAR(420)
  , IN `v_saldo_anterior` VARCHAR(430)
  , IN `v_saldo_nuevo` VARCHAR(440)
  , IN `v_importe` VARCHAR(450)
  , IN `v_titular_cuenta` VARCHAR(460)
  , IN `v_refvc` VARCHAR(470)
  , IN `v_id_concepto` VARCHAR(480)
  , IN `v_descripcion` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
        BEGIN

            DECLARE v_b_exists INTEGER(1) ;

            SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

            INSERT INTO cuenta_movimientos(  
              id_cliente
              , id_paypal
              , id_movimiento
              , tipo_movimiento
              , saldo_anterior
              , saldo_nuevo
              , importe
              , monto_total
              , titular_cuenta
              , refvc
              , id_concepto
              , descripcion
              , fecha_movimiento
              , creado_por
              , refInt
              , refInt2
              , modificado
              , activo
              , id_cuenta_movimientos
              , id_cliente
              , id_paypal
              , id_movimiento
              , tipo_movimiento
              , saldo_anterior
              , saldo_nuevo
              , importe
              , titular_cuenta
              , refvc
              , id_concepto
              , descripcion
            )
            SELECT  v_id_cliente
            , v_id_paypal
            , v_id_movimiento
            , v_tipo_movimiento
            , v_saldo_anterior
            , v_saldo_nuevo
            , v_importe
            , v_monto_total
            , v_titular_cuenta
            , v_refvc
            , v_id_concepto
            , v_descripcion
            , v_fecha_movimiento
            , v_creado_por
            , v_refInt
            , v_refInt2
            , v_modificado
            , v_activo
            , v_id_cuenta_movimientos
            , v_id_cliente
            , v_id_paypal
            , v_id_movimiento
            , v_tipo_movimiento
            , v_saldo_anterior
            , v_saldo_nuevo
            , v_importe
            , v_titular_cuenta
            , v_refvc
            , v_id_concepto
            , v_descripcion

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_importar_cuenta_movimientos`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_importar_cuenta_movimientos`(IN `v_id` BIGINT(20)
  , IN `v_id_cliente` VARCHAR(200)
  , IN `v_id_paypal` VARCHAR(210)
  , IN `v_id_movimiento` VARCHAR(220)
  , IN `v_tipo_movimiento` VARCHAR(230)
  , IN `v_saldo_anterior` VARCHAR(240)
  , IN `v_saldo_nuevo` VARCHAR(250)
  , IN `v_importe` VARCHAR(260)
  , IN `v_monto_total` VARCHAR(270)
  , IN `v_titular_cuenta` VARCHAR(280)
  , IN `v_refvc` VARCHAR(290)
  , IN `v_id_concepto` VARCHAR(300)
  , IN `v_descripcion` VARCHAR(310)
  , IN `v_fecha_movimiento` VARCHAR(320)
  , IN `v_creado_por` VARCHAR(330)
  , IN `v_refInt` VARCHAR(340)
  , IN `v_refInt2` VARCHAR(350)
  , IN `v_modificado` VARCHAR(360)
  , IN `v_activo` VARCHAR(370)
  , IN `v_id_cuenta_movimientos` VARCHAR(380)
  , IN `v_id_cliente` VARCHAR(390)
  , IN `v_id_paypal` VARCHAR(400)
  , IN `v_id_movimiento` VARCHAR(410)
  , IN `v_tipo_movimiento` VARCHAR(420)
  , IN `v_saldo_anterior` VARCHAR(430)
  , IN `v_saldo_nuevo` VARCHAR(440)
  , IN `v_importe` VARCHAR(450)
  , IN `v_titular_cuenta` VARCHAR(460)
  , IN `v_refvc` VARCHAR(470)
  , IN `v_id_concepto` VARCHAR(480)
  , IN `v_descripcion` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
    BEGIN

        DECLARE v_b_exists INTEGER(1) ;

        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        SELECT COUNT(*) INTO v_b_exists 
        FROM cuenta_movimientos 
        WHERE id= v_id AND activo > 0 LIMIT 1 ;

        IF (v_b_exists > 0) THEN BEGIN
            UPDATE cuenta_movimientos 
            SET id_cliente   = v_id_cliente
              , id_paypal   = v_id_paypal
              , id_movimiento   = v_id_movimiento
              , tipo_movimiento   = v_tipo_movimiento
              , saldo_anterior   = v_saldo_anterior
              , saldo_nuevo   = v_saldo_nuevo
              , importe   = v_importe
              , monto_total   = v_monto_total
              , titular_cuenta   = v_titular_cuenta
              , refvc   = v_refvc
              , id_concepto   = v_id_concepto
              , descripcion   = v_descripcion
              , fecha_movimiento   = v_fecha_movimiento
              , creado_por   = v_creado_por
              , refInt   = v_refInt
              , refInt2   = v_refInt2
              , modificado   = v_modificado
              , activo   = v_activo
              , id_cuenta_movimientos   = v_id_cuenta_movimientos
              , id_cliente   = v_id_cliente
              , id_paypal   = v_id_paypal
              , id_movimiento   = v_id_movimiento
              , tipo_movimiento   = v_tipo_movimiento
              , saldo_anterior   = v_saldo_anterior
              , saldo_nuevo   = v_saldo_nuevo
              , importe   = v_importe
              , titular_cuenta   = v_titular_cuenta
              , refvc   = v_refvc
              , id_concepto   = v_id_concepto
              , descripcion   = v_descripcion
            WHERE id= v_id ;
            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

        IF (v_b_exists = 0) THEN BEGIN
            INSERT INTO cuenta_movimientos(  
              id_cliente
              , id_paypal
              , id_movimiento
              , tipo_movimiento
              , saldo_anterior
              , saldo_nuevo
              , importe
              , monto_total
              , titular_cuenta
              , refvc
              , id_concepto
              , descripcion
              , fecha_movimiento
              , creado_por
              , refInt
              , refInt2
              , modificado
              , activo
              , id_cuenta_movimientos
              , id_cliente
              , id_paypal
              , id_movimiento
              , tipo_movimiento
              , saldo_anterior
              , saldo_nuevo
              , importe
              , titular_cuenta
              , refvc
              , id_concepto
              , descripcion
            )
            SELECT  v_id_cliente
            , v_id_paypal
            , v_id_movimiento
            , v_tipo_movimiento
            , v_saldo_anterior
            , v_saldo_nuevo
            , v_importe
            , v_monto_total
            , v_titular_cuenta
            , v_refvc
            , v_id_concepto
            , v_descripcion
            , v_fecha_movimiento
            , v_creado_por
            , v_refInt
            , v_refInt2
            , v_modificado
            , v_activo
            , v_id_cuenta_movimientos
            , v_id_cliente
            , v_id_paypal
            , v_id_movimiento
            , v_tipo_movimiento
            , v_saldo_anterior
            , v_saldo_nuevo
            , v_importe
            , v_titular_cuenta
            , v_refvc
            , v_id_concepto
            , v_descripcion

            FROM DUAL WHERE TRUE;

            SET v_i_response := LAST_INSERT_ID();
        END; END IF;

    END ;;
DELIMITER ;

DROP PROCEDURE IF EXISTS `sp_set_update_cuenta_movimientos`;

DELIMITER ;;
CREATE PROCEDURE `sp_set_update_cuenta_movimientos`(IN `v_id` BIGINT(20)
  , IN `v_id_cliente` VARCHAR(200)
  , IN `v_id_paypal` VARCHAR(210)
  , IN `v_id_movimiento` VARCHAR(220)
  , IN `v_tipo_movimiento` VARCHAR(230)
  , IN `v_saldo_anterior` VARCHAR(240)
  , IN `v_saldo_nuevo` VARCHAR(250)
  , IN `v_importe` VARCHAR(260)
  , IN `v_monto_total` VARCHAR(270)
  , IN `v_titular_cuenta` VARCHAR(280)
  , IN `v_refvc` VARCHAR(290)
  , IN `v_id_concepto` VARCHAR(300)
  , IN `v_descripcion` VARCHAR(310)
  , IN `v_fecha_movimiento` VARCHAR(320)
  , IN `v_creado_por` VARCHAR(330)
  , IN `v_refInt` VARCHAR(340)
  , IN `v_refInt2` VARCHAR(350)
  , IN `v_modificado` VARCHAR(360)
  , IN `v_activo` VARCHAR(370)
  , IN `v_id_cuenta_movimientos` VARCHAR(380)
  , IN `v_id_cliente` VARCHAR(390)
  , IN `v_id_paypal` VARCHAR(400)
  , IN `v_id_movimiento` VARCHAR(410)
  , IN `v_tipo_movimiento` VARCHAR(420)
  , IN `v_saldo_anterior` VARCHAR(430)
  , IN `v_saldo_nuevo` VARCHAR(440)
  , IN `v_importe` VARCHAR(450)
  , IN `v_titular_cuenta` VARCHAR(460)
  , IN `v_refvc` VARCHAR(470)
  , IN `v_id_concepto` VARCHAR(480)
  , IN `v_descripcion` VARCHAR(490)
  , OUT `v_i_response` INTEGER)
    MODIFIES SQL DATA
BEGIN

  SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

  UPDATE cuenta_movimientos 
  SET id_cliente   = v_id_cliente
    , id_paypal   = v_id_paypal
    , id_movimiento   = v_id_movimiento
    , tipo_movimiento   = v_tipo_movimiento
    , saldo_anterior   = v_saldo_anterior
    , saldo_nuevo   = v_saldo_nuevo
    , importe   = v_importe
    , monto_total   = v_monto_total
    , titular_cuenta   = v_titular_cuenta
    , refvc   = v_refvc
    , id_concepto   = v_id_concepto
    , descripcion   = v_descripcion
    , fecha_movimiento   = v_fecha_movimiento
    , creado_por   = v_creado_por
    , refInt   = v_refInt
    , refInt2   = v_refInt2
    , modificado   = v_modificado
    , activo   = v_activo
    , id_cuenta_movimientos   = v_id_cuenta_movimientos
    , id_cliente   = v_id_cliente
    , id_paypal   = v_id_paypal
    , id_movimiento   = v_id_movimiento
    , tipo_movimiento   = v_tipo_movimiento
    , saldo_anterior   = v_saldo_anterior
    , saldo_nuevo   = v_saldo_nuevo
    , importe   = v_importe
    , titular_cuenta   = v_titular_cuenta
    , refvc   = v_refvc
    , id_concepto   = v_id_concepto
    , descripcion   = v_descripcion
  WHERE id= v_id ;
  SET v_i_response := LAST_INSERT_ID();

END ;;
DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_undo_delete_cuenta_movimientos`;
DELIMITER ;;
    CREATE PROCEDURE `sp_undo_delete_cuenta_movimientos`(IN `v_id` BIGINT(20), OUT `v_i_internal_status` INTEGER)
    MODIFIES SQL DATA
    BEGIN
        SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;

        UPDATE cuenta_movimientos SET activo= 1
        WHERE id= v_id;
        SET v_i_internal_status:= ROW_COUNT();

    END ;;
DELIMITER ;

