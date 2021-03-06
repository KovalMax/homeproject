<?php


namespace App\Service;


use App\DTO\Request\UserRegistration;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class UserRegistrationService
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    public function __construct(UserPasswordEncoderInterface $encoder, UserRepository $repository)
    {
        $this->encoder = $encoder;
        $this->repository = $repository;
    }

    /**
     * @param UserRegistration $userRegistration
     *
     * @throws \Exception
     */
    public function createNewUser(UserRegistration $userRegistration): void
    {
        $user = (new User())
            ->setEmail($userRegistration->email)
            ->setFirstName($userRegistration->firstName)
            ->setLastName($userRegistration->lastName)
            ->setTimezone($userRegistration->timezone);

        $user->setPassword($this->encoder->encodePassword($user, $userRegistration->password));

        $this->repository->save($user);
    }
}