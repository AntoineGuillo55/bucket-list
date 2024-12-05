<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BucketTest extends WebTestCase
{
    public function testHomePageIsWorking(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bucket List');
    }

    public function testCreateWishIfNotLogged(){

        $client = static::createClient();
        $crawler = $client->request('GET', '/wish/add');

        $this->assertResponseRedirects('/login', 302);
    }

    public function testCreateWishIfLogged() {

        $client = static::createClient();

        $userRepository = self::getContainer()->get(UserRepository::class);
        $user = $userRepository->find(11);

        $client->loginUser($user);

        $crawler = $client->request('GET', '/wish/add');

        $this->assertResponseIsSuccessful();

        $client->submitForm('Create !', [
            'wish[title]' => 'Voeux test',
            'wish[description]' => 'test',
            'wish[category]' => 36
        ]);

        $this->assertResponseStatusCodeSame(302);

        $client->followRedirect();

        $this->assertRouteSame('wish_detail');
    }
}
