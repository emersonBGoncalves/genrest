package com.genrest.model;

import java.util.List;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.JoinTable;
import javax.persistence.ManyToMany;
import javax.persistence.Table;


@Entity
@Table(name="clientes")
public class Usuario {

	@Id
	@Column(name="clientes_id")
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private Long id;
	
	@Column(name="clientes_nome", nullable = false)
	private String username;
	
	@Column(name="clientes_email", unique = true, nullable = false)
	private String email;
	
	@Column(name="clientes_pass", nullable = false)
	private String senha;
	
	@Column(name="clientes_cpfcnpj", unique = true, nullable = false)
	private String cpfCnpj;
	
	@Column(name="clientes_insc_estadual")
	private String inscricaoEstadual;

	@Column(name="clientes_telefone")
	private String telefone;

	@Column(name="clientes_plano")
	private int plano;

	@Column(name = "clientes_qtd_funcoes")
	private Long qtdFuncoes;

	@Column(name = "clientes_host")
	private String host;

	@Column(name = "clientes_userdb")
	private String userDB;

	@Column(name = "clientes_db")
	private String database;

	@Column(name = "clientes_passdb")
	private String senhaDatabase;

	@Column(name = "clientes_habilita_insert")
	private int habilita_insert;

	@Column(name = "clientes_habilita_update")
	private int habilita_update;

	@Column(name = "clientes_habilita_delete")
	private int habilita_delete;

	@Column(name = "clientes_verificado")
	private int verificado;

	@ManyToMany
	@JoinTable(
		name = "clientes_permissoes", 
				//referencia usuario_id da tabela usuarios_tem_perfis na id_usuario da tabela usuario
		joinColumns = { @JoinColumn(name = "id_cliente", referencedColumnName = "clientes_id") },
        inverseJoinColumns = { @JoinColumn(name = "id_permissao", referencedColumnName = "id_permissao") }
	)
	private List<Permissao> permissoes;

	/*
	@OneToMany
    @JoinColumn(name="tokens_cliente_id", referencedColumnName = "clientes_id")
	private List<Token> tokens;
	 */
	
	public Long getId() {
		return id;
	}

	public void setId(Long id) {
		this.id = id;
	}

	public String getUsername() {
		return username;
	}

	public void setUsername(String username) {
		this.username = username;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public String getSenha() {
		return senha;
	}

	public void setSenha(String senha) {
		this.senha = senha;
	}

	public String getCpfCnpj() {
		return cpfCnpj;
	}

	public void setCpfCnpj(String cpfCnpj) {
		this.cpfCnpj = cpfCnpj;
	}

	public String getInscricaoEstadual() {
		return inscricaoEstadual;
	}

	public void setInscricaoEstadual(String inscricaoEstadual) {
		this.inscricaoEstadual = inscricaoEstadual;
	}

	public String getTelefone() {
		return telefone;
	}

	public void setTelefone(String telefone) {
		this.telefone = telefone;
	}

	public int getPlano() {
		return plano;
	}

	public void setPlano(int plano) {
		this.plano = plano;
	}

	public Long getQtdFuncoes() {
		return qtdFuncoes;
	}

	public void setQtdFuncoes(Long qtdFuncoes) {
		this.qtdFuncoes = qtdFuncoes;
	}

	public String getHost() {
		return host;
	}

	public void setHost(String host) {
		this.host = host;
	}

	public String getUserDB() {
		return userDB;
	}

	public void setUserDB(String userDB) {
		this.userDB = userDB;
	}

	public String getDatabase() {
		return database;
	}

	public void setDatabase(String database) {
		this.database = database;
	}

	public String getSenhaDatabase() {
		return senhaDatabase;
	}

	public void setSenhaDatabase(String senhaDatabase) {
		this.senhaDatabase = senhaDatabase;
	}

	public int getHabilita_insert() {
		return habilita_insert;
	}

	public void setHabilita_insert(int habilita_insert) {
		this.habilita_insert = habilita_insert;
	}

	public int getHabilita_update() {
		return habilita_update;
	}

	public void setHabilita_update(int habilita_update) {
		this.habilita_update = habilita_update;
	}

	public int getHabilita_delete() {
		return habilita_delete;
	}

	public void setHabilita_delete(int habilita_delete) {
		this.habilita_delete = habilita_delete;
	}

	public int getVerificado() {
		return verificado;
	}

	public void setVerificado(int verificado) {
		this.verificado = verificado;
	}

	public List<Permissao> getPermissoes() {
		return permissoes;
	}

	public void setPermissoes(List<Permissao> permissoes) {
		this.permissoes = permissoes;
	}
	
	public boolean dadosBancoMudou(Usuario user) {
		if(!(this.host.equals(user.getHost()))
		|| !(this.database.equals(user.getDatabase()))
		|| !(this.userDB.equals(user.getUserDB()))
		|| (this.senhaDatabase.length() > 0)
		|| (this.habilita_insert != user.getHabilita_insert())
		|| (this.habilita_update != user.getHabilita_update())
		|| (this.habilita_delete != user.getHabilita_delete())
		){
			if(!(this.host.equals(user.getHost()))) {
				System.out.println("host diferente: " + this.host + " : " + user.getHost());
			}
			if(!this.database.equals(user.getDatabase())){
				System.out.println("database diferente: " + this.database + " : " + user.getDatabase());
			}
			if(!this.userDB.equals(user.getUserDB())){
				System.out.println("userDB diferente: " + this.userDB + " : " + user.getUserDB());
			}
			if(this.senhaDatabase.length() > 0){
				System.out.println("Senha > 0: " + this.senhaDatabase + " tamanho: " + this.senhaDatabase.length());
			}
			if(this.habilita_insert != user.getHabilita_insert()) {
				System.out.println("Habilita insert diferente: " + this.habilita_insert + " : " + user.getHabilita_insert());
			}
			if(this.habilita_update != user.getHabilita_update()) {
				System.out.println("Habilita update diferente: " + this.habilita_update + " : " + user.getHabilita_update());
			}
			if(this.habilita_delete != user.getHabilita_delete()) {
				System.out.println("Habilita delete diferente: " + this.habilita_delete + " : " + user.getHabilita_delete());
			}
			return true;
		}
		return false;
	}

	@Override
	public String toString() {
		return "Usuario [id=" + id + ", username=" + username + ", email=" + email + ", senha=" + senha + ", cpfCnpj=" + cpfCnpj + ", inscricaoEstadual=" + inscricaoEstadual + ", telefone="
				+ telefone + ", qtdFuncoes=" + qtdFuncoes + ", host=" + host
				+ ", userDB=" + userDB + ", database=" + database + ", senhaDatabase=" + senhaDatabase
				+ ", habilita_insert=" + habilita_insert + ", habilita_update=" + habilita_update + ", habilita_delete="
				+ habilita_delete + ", permissoes=" + permissoes + "]";
	}
}
