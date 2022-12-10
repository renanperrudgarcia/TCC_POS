<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Gravasituacao
 * @ORM\Table(schema="public", name="usuario")
 * @ORM\Entity 
 */
final class Usuario extends Entity
{
    /**
     * @var int
     * @ORM\Id 
     * @ORM\Column(name="id", type="integer")
     */
    protected int $id;

    /**
     * @var string
     * @ORM\Column(name="nome", type="string")
     */
    protected string $nome;

    /**
     * @var string
     * @ORM\Column(name="usuario", type="string")
     */
    protected string $usuario;

    /**
     * @var string
     * @ORM\Column(name="senha", type="string")
     */
    protected string $senha;

    /**
     * @var int
     * @ORM\Column(name="tipo_usuario", type="integer")
     */
    protected int $tipo_usuario;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */
    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of usuario
     */
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     */
    public function setUsuario(string $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get the value of senha
     */
    public function getSenha(): string
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     */
    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    public function getTipoUsuario(): int
    {
        return $this->tipo_usuario;
    }

    public function setTipoUsuario(int $tipo_usuario): self
    {
        $this->tipo_usuario = $tipo_usuario;

        return $this;
    }
}
