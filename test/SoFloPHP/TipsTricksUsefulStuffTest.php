<?php

namespace SoFloPHP;

use Xpmock\TestCase;

class TipsTricksUsefulStuffTest extends TestCase
{
    public function testPersistInsertsNewAccountsIntoTheDatabaseMockedVersion()
    {
        $stmt = $this->mock('stdClass')
            ->execute([500], $this->once())
            ->new();

        $pdo = $this->mock('PDO')
            ->prepare(['insert into account (balance) values (?)'], $stmt, $this->once())
            ->lastInsertId(1, $this->once())
            ->new('sqlite::memory:');
        $service = new BankAccountService($pdo);

        $account = new BankAccount();
        $account->deposit(500);
        $newAccountId = $service->persist($account);
        $this->assertEquals(1, $newAccountId);
    }
}
