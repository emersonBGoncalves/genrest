package com.genrest.repository;

import java.util.List;

import com.genrest.model.Doc;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface DocRepository extends JpaRepository<Doc, Long> {

	List<Doc> findByClienteId(Long id);
}