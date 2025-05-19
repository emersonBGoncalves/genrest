package com.genrest.repository;

import java.util.List;
import java.util.Optional;

import javax.transaction.Transactional;

import com.genrest.model.Confirmacao;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;

@Repository
public interface ConfirmacaoRepository extends JpaRepository<Confirmacao, Long> {

    @Query(value = "SELECT id, cliente_id, token, enviado, usado FROM confirmacao WHERE token = :token and usado = 0 and enviado = 1", nativeQuery = true)
	List<Confirmacao> RetornaConfirmacaoToken(@Param("token") Optional<Long> token);

	@Modifying
	@Transactional
	@Query(value = "insert into confirmacao(cliente_id, token, enviado) values(:id, :token, 1)", nativeQuery = true)
	void salvarConfirmacao(@Param("id") Long clienteId, @Param("token") int token);

	@Modifying
	@Transactional
	@Query(value = "update confirmacao set usado = 1 where cliente_id = :id", nativeQuery = true)
	Integer setaConfirmacaoUsado(@Param("id") Long id);
}
