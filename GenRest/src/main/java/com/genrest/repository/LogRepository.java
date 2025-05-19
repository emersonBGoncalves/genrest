package com.genrest.repository;

import java.util.List;

import com.genrest.model.Log;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;
import org.springframework.stereotype.Repository;

@Repository
public interface LogRepository extends JpaRepository<Log, Long> {

    List<Log> findByClienteId(Long id);

    @Query(value = "SELECT 0 AS logs_cliente_id, '' AS logs_usuario, '' AS logs_data, COUNT(*) AS logs_dados, HOUR(logs_data) AS logs_id FROM logs WHERE logs_cliente_id = :id AND logs_data LIKE CONCAT( '%', YEAR(NOW()), '-', DATE_FORMAT(NOW(), '%m'), '-', DATE_FORMAT(NOW(), '%d'), '%' ) GROUP BY HOUR(logs_data) ORDER BY logs_id ;", nativeQuery = true)
    List<Log> getUsoHora(Long id);
   
    @Query(value = "SELECT 0 AS logs_cliente_id, '' AS logs_usuario, '' AS logs_data, COUNT(*) AS logs_dados, DAY(logs_data) AS logs_id FROM `logs` WHERE logs_cliente_id = :id AND logs_data LIKE CONCAT('%', YEAR(NOW()),'-', DATE_FORMAT(NOW(),'%m'), '%') GROUP BY DAY(logs_data) ORDER BY logs_id;", nativeQuery = true)
    List<Log> getUsoMes(Long id);
    
    @Query(value = "SELECT logs_id, 0 AS logs_cliente_id, '' AS logs_data, COUNT(*) AS logs_dados, logs_usuario FROM `logs` WHERE logs_cliente_id = :id AND logs_data BETWEEN CONCAT(YEAR(NOW()),'-', DATE_FORMAT(NOW(),'%m'), '-' , DATE_FORMAT(NOW(),'%d'), ' 00:00:00') AND NOW() GROUP BY logs_usuario;", nativeQuery = true)
    List<Log> getUsuariosDia(Long id);

    @Query(value = "SELECT logs_id, 0 AS logs_cliente_id, '' AS logs_data, COUNT(*) AS logs_dados, logs_usuario FROM `logs` WHERE logs_cliente_id = :id AND logs_data BETWEEN CONCAT(DATE_FORMAT(NOW(),'%Y-%m-01'), ' 00:00:00') AND NOW() GROUP BY logs_usuario;", nativeQuery = true)
    List<Log> getUsuariosMes(Long id);
    
    @Query(value = "CALL getQtdRequisicoes(:id);", nativeQuery = true)
    Long getQtdRequisicoes(Long id);
}