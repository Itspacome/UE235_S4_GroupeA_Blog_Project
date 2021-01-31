<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        //Gestion utilisateurs
        $users = [];

        $user = new User();
        $user->setPseudo('John');
        $user->setPassword($this->encoder->encodePassword($user,'mdp'));
        $manager->persist($user);

        $user = new User();
        $user->setPseudo('Paul');
        $user->setPassword($this->encoder->encodePassword($user,'mdp'));
        $manager->persist($user);
 
        $users[] = $user;

        //Gestion des catégories
        $category = new Category();

        $category->setName("Catégorie 1");
        $manager->persist($category);

        //Gestion des articles
        for ($i=1; $i <= 24 ; $i++) { 
            $article = new Article();

            $user = $users[mt_rand(0, count($users) - 1)];

            $article->setTitle('Article ' . $i);
            $article->setContent('Proinde die funestis interrogationibus praestituto imaginarius iudex equitum resedit magister adhibitis aliis iam quae essent agenda praedoctis, et adsistebant hinc inde notarii, quid quaesitum esset, quidve responsum, cursim ad Caesarem perferentes, cuius imperio truci, stimulis reginae exsertantis aurem subinde per aulaeum, nec diluere obiecta permissi nec defensi periere conplures.');
            $article->setCategory($category);
            $article->setAuthor($user);

            $manager->persist($article);
        }

        $manager->flush();
    }
}
