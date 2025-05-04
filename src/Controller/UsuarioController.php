<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/usuarios')]
class UsuarioController extends AbstractController
{
    private UsuarioRepository $usuarioRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UsuarioRepository $usuarioRepository, EntityManagerInterface $entityManager)
    {
        $this->usuarioRepository = $usuarioRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', methods: ['GET'])]
    public function getAllUsuarios(): JsonResponse
    {
        $usuarios = $this->usuarioRepository->findAll();
        return $this->json($usuarios);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getUsuario(int $id): JsonResponse
    {
        $usuario = $this->usuarioRepository->find($id);
        if (!$usuario) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }
        return $this->json($usuario);
    }

    #[Route('/', methods: ['POST'])]
    public function createUsuario(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['nombre']) || !isset($data['email']) || !isset($data['contraseña'])) {
            return $this->json(['error' => 'Datos incompletos'], 400);
        }

        $usuario = new Usuario();
        $usuario->setNombre($data['nombre']);
        $usuario->setEmail($data['email']);
        $usuario->setContraseña(password_hash($data['contraseña'], PASSWORD_DEFAULT));

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        return $this->json(['message' => 'Usuario creado correctamente'], 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function updateUsuario(int $id, Request $request): JsonResponse
    {
        $usuario = $this->usuarioRepository->find($id);
        if (!$usuario) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['nombre'])) {
            $usuario->setNombre($data['nombre']);
        }
        if (isset($data['email'])) {
            $usuario->setEmail($data['email']);
        }
        if (isset($data['contraseña'])) {
            $usuario->setContraseña(password_hash($data['contraseña'], PASSWORD_DEFAULT));
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'Usuario actualizado correctamente']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteUsuario(int $id): JsonResponse
    {
        $usuario = $this->usuarioRepository->find($id);
        if (!$usuario) {
            return $this->json(['error' => 'Usuario no encontrado'], 404);
        }

        $this->entityManager->remove($usuario);
        $this->entityManager->flush();

        return $this->json(['message' => 'Usuario eliminado correctamente']);
    }

    #[Route('/login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $usuario = $this->usuarioRepository->findOneBy(['email' => $data['email']]);
    
        if (!$usuario || !password_verify($data['contraseña'], $usuario->getContraseña())) {
            return $this->json(['error' => 'Credenciales inválidas'], 401);
        }
    
        return $this->json($usuario); // 👈 devuelve el usuario completo
    }
    
}