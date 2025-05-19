package com.genrest.model;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;

import org.springframework.format.annotation.DateTimeFormat;

@Entity
@Table(name = "logs")
public class Log {

    @Id
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	@Column(name="logs_id")
	private Long id;

    @Column(name="logs_cliente_id")
	private Long clienteId;

    @Column(name="logs_usuario")
    private String usuario;

    @Column(name="logs_data")
    private String data;

	@Column(name="logs_data", insertable = false, updatable = false)
	@DateTimeFormat(pattern = "dd/MM/yyyy")
    private String dia;

	@Column(name="logs_data", insertable = false, updatable = false)
	@DateTimeFormat(pattern = "HH:mm:ss")
    private String hora;

    @Column(name="logs_dados")
    private String dados;

	public Long getId() {
		return id;
	}

	public void setId(Long id) {
		this.id = id;
	}

	public Long getClienteId() {
		return clienteId;
	}

	public void setClienteId(Long clienteId) {
		this.clienteId = clienteId;
	}

	public String getUsuario() {
		return usuario;
	}

	public void setUsuario(String usuario) {
		this.usuario = usuario;
	}

	public String getData() {
		return data;
	}

	public void setData(String data) {
		this.data = data;
	}
	
	public String getDia() {
		//SimpleDateFormat sdf = new SimpleDateFormat("dd/MM/yyyy");
		//String diaFormatada = sdf.format(this.data);
		return this.data;
	}

	public void setDia(String dia) {
		this.dia = dia;
	}

	public String getHora() {
		//SimpleDateFormat sdf = new SimpleDateFormat("HH");
		//String horaFormatada = sdf.format(this.data);
		return this.data;
	}

	public void setHora(String hora) {
		this.hora = hora;
	}

	public String getDados() {
		return dados;
	}

	public void setDados(String dados) {
		this.dados = dados;
	}

}
