package com.genrest.repository;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import javax.transaction.Transactional;
import com.genrest.model.Usuario;

@Repository
public interface UsuarioRepository extends JpaRepository<Usuario, Long>{

	Usuario findByUsername(String username);
	Usuario findByCpfCnpj(String cpfCnpj);
	Usuario findByEmail(String email);

	@Modifying
	@Transactional
	@Query(value = "insert into clientes_permissoes(id_cliente, id_permissao) values(:id, :permissao)", nativeQuery = true)
	Integer insertPermissao(@Param("id") Long id, @Param("permissao") int permissao);

	@Modifying
	@Transactional
	@Query(value = "update clientes_permissoes set id_permissao = :permissao where id_cliente = :id", nativeQuery = true)
	Integer updatePermissao(@Param("id") Long id, @Param("permissao") int permissao);

	@Modifying
	@Transactional
	@Query(value = "update clientes set clientes_pass = :senha where clientes_id = :id", nativeQuery = true)
	Integer alteraSenha(@Param("id") Long id, @Param("senha") String senha);

	@Modifying
	@Transactional
	@Query(value = "update clientes set clientes_verificado = 1 where clientes_id = :id", nativeQuery = true)
	Integer ConfirmaEmail(@Param("id") Long id);
	
	Usuario findByEmailAndVerificado(String email, int i);
    
}