<?php

namespace App\Test\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItemControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ItemRepository $repository;
    private string $path = '/item/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Item::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Item index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'item[name]' => 'Testing',
            'item[description]' => 'Testing',
            'item[priority]' => 'Testing',
            'item[create_date]' => 'Testing',
            'item[updated_at]' => 'Testing',
            'item[client]' => 'Testing',
        ]);

        self::assertResponseRedirects('/item/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Item();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPriority('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setClient('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Item');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Item();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPriority('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setClient('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'item[name]' => 'Something New',
            'item[description]' => 'Something New',
            'item[priority]' => 'Something New',
            'item[create_date]' => 'Something New',
            'item[updated_at]' => 'Something New',
            'item[client]' => 'Something New',
        ]);

        self::assertResponseRedirects('/item/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getPriority());
        self::assertSame('Something New', $fixture[0]->getCreate_date());
        self::assertSame('Something New', $fixture[0]->getUpdated_at());
        self::assertSame('Something New', $fixture[0]->getClient());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Item();
        $fixture->setName('My Title');
        $fixture->setDescription('My Title');
        $fixture->setPriority('My Title');
        $fixture->setCreate_date('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setClient('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/item/');
    }
}
