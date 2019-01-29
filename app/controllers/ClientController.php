<?php
namespace app\controllers;

/**
 * Контроллер клиентов фирмы
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class ClientController extends \tachyon\Controller
{
    use \app\dic\ClientRepository;
    use \app\dic\Client;
    use \app\dic\RegionRepository;
    use \app\traits\MenuTrait;

    public function index()
    {
        $this->layout('index', array(
            'entity' => $this->client,
            'clients' => $this->clientRepository->findAll(),
        ));
    }

    public function update($pk)
    {
        /**
         * @var \app\entities\Client $client
         */
        if (!$client = $this->clientRepository->findByPk($pk)) {
            $this->error(404, $this->msg->i18n('Wrong address.'));
        }
        if (!empty($this->post)) {
            $client->setAttributes($this->post['Client'] ?? $this->post);
            //if ($client->validate()) {
                if ($client->getDbContext()->commit()) {
                    $this->message = 'Сохранено успешно';
                    $this->redirect("/{$this->id}");
                }
            //}
            $this->message = 'Что то пошло не так';
        }
        $regions = $this->regionRepository->findAll();
        $this->layout('update', compact('client', 'regions'));
    }

    public function delete($pk)
    {
        /*echo json_encode(array(
            'success' => $this->clientRepository
                ->findByPk($pk)
                ->delete()
        ));*/
    }
}