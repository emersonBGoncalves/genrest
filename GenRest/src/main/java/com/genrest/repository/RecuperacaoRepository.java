package com.genrest.repository;

import java.util.List;
import java.util.Optional;

import javax.transaction.Transactional;

import com.genrest.model.Recuperacao;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

@Repository
public interface RecuperacaoRepository extends JpaRepository<Recuperacao, Long> {
    
    @Modifying
	@Transactional
	@Query(value = "insert into recuperacao(cliente_id, token) values(:id, :token)", nativeQuery = true)
	void salvarRecuperacao(@Param("id") Long clienteId, @Param("token") int token);

    @Query(value = "SELECT id, cliente_id, token, enviado, usado FROM recuperacao WHERE token = :token and usado = 0 and enviado = 1", nativeQuery = true)
	List<Recuperacao> RetornaRecuperacaoToken(@Param("token") Optional<Long> token);
	
	@Modifying
	@Transactional
	@Query(value = "update recuperacao set usado = 1 where cliente_id = :id", nativeQuery = true)
	Integer setaRecuperacaoUsado(@Param("id") Long id);
}
