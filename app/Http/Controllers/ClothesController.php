<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Look\Application\Client\IdentifyClient\IdentifyClientRequest;
use Look\Application\Client\IdentifyClient\Interface\IdentifyClientInterface;
use Look\Application\Clothes\ChooseClothes\ChooseClothesRequest;
use Look\Application\Clothes\ChooseClothes\Interface\ChooseClothesInterface;
use Look\Application\Clothes\GetClothesForClient\GetClothesForClientRequest;
use Look\Application\Clothes\GetClothesForClient\Interface\GetClothesForClientInterface;
use Look\Domain\Clothes\Interface\ClothesInterface;

class ClothesController extends Controller
{
    public function getClothes(
        Request $request,
        GetClothesForClientInterface $getClothes,
        IdentifyClientInterface $identifyClient
    ): JsonResponse {
        $request->validate([
            'page' => 'required|numeric',
            'perPage' => 'required|numeric'
        ]);

        $clientRequest = new IdentifyClientRequest(668093623);
        $clientResponse = $identifyClient->identifyClientFromTelegram($clientRequest);

        $clothesRequest = new GetClothesForClientRequest(
            $clientResponse->getClient(),
            $request->get('page'),
            $request->get('perPage')
        );

        $clothesResponse = $getClothes->getClothesForClient($clothesRequest);

        if ($clothesResponse->isSuccess()) {
            $clothesPagination = $clothesResponse->getClothes();

            $items = array_map(static fn (ClothesInterface $clothes) => [
                'id' => $clothes->getId()->getValue(),
                'name' => $clothes->getName()->getValue(),
                'photo' => $clothes->getPhoto()->getValue(),
                'is_chosen' => $clothes->isChosen()
            ], $clothesPagination->getItems());

            return response()->json([
                'success' => true,
                'items' => $items,
                'page' => $clothesPagination->getPage(),
                'page_total' => $clothesPagination->getPageTotal()
            ]);
        }

        return response()->json(['success' => false]);
    }

    public function chooseClothes(
        Request $request,
        IdentifyClientInterface $identifyClient,
        ChooseClothesInterface $chooseClothes
    ): JsonResponse {
        $request->validate([
            'clothes_id' => 'required|numeric'
        ]);

        $clientRequest = new IdentifyClientRequest(668093623);
        $clientResponse = $identifyClient->identifyClientFromTelegram($clientRequest);

        if ($clientResponse->isIdentified()) {
            $chooseClothesRequest = new ChooseClothesRequest(
                $clientResponse->getClient(),
                $request->get('clothes_id')
            );
            $chooseClothesResponse = $chooseClothes->chooseClothes($chooseClothesRequest);

            $response = ['success' => $chooseClothesResponse->isSuccess()];

            if (!$chooseClothesResponse->isSuccess()) {
                $response['message'] = $chooseClothesResponse->getError();
            }

            return response()->json($response);
        }

        return response()->json(['success' => false]);
    }
}
