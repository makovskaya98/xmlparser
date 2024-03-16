<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    /**
     * /api/offers?perpage=n&page=m
     * perpage - Кол-во записей на странице.
     * page - Получение номера страницы
     * /api/offers?include=category
     */
    public function index(Request $request)
    {
        $perPage = $this->validatePerPage($request);
        $page = $request->query('page', $request->page ?? 25);

        if (!is_numeric($page) || $page <= 0) {
            abort(400, 'Номером страницы должно быть положительное число.');
        }

        $with = $request->query('include');

        $offers = Offers::with($with ?: [])->paginate($perPage, ['*'], 'page', $page);

        return response()->json($offers);
    }

    private function validatePerPage(Request $request): int
    {
        $perPage = $request->perpage ?? 25;

        if (!is_numeric($perPage) || $perPage <= 0) {
            abort(400, 'Количество записей на странице должно быть положительное число.');
        }

        return (int)$perPage;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }
    /**
     * /api/offers/id
     * Получение offer по id
    */
    public function show(Offers $offer)
    {
        return response()->json($offer);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
