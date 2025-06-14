package com.genrest.repository;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import com.genrest.model.Token;

@Repository
public interface TokenRepository extends JpaRepository<Token, Long>{

	List<Token> findByClienteId(Long clienteId);
	Token findByUsuario(String usuario);
	Token existsByUsuario(String usuario);
    Token findByUsuarioAndClienteId(String usuario, Long clienteId);
}
