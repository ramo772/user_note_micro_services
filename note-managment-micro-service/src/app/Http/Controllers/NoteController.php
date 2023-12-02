<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Note\CreateNoteRequest;
use App\Http\Requests\Api\Note\UpdateNoteRequest;
use App\Http\Services\NoteService;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function __construct(
        protected NoteService $noteService,
    ) {
        $this->noteService = $noteService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $response = $this->noteService->findAll($request->user_id);
        return  $this->setCode($response['code'])->setMessages($response['messages'])->setData($response['data'])->customResponse();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNoteRequest $request)
    {
        $response = $this->noteService->create($request->validated());
        return  $this->setCode($response['code'])->setMessages($response['messages'])->setData($response['data'])->customResponse();
    }


    public function show(Request $request, string $id)
    {
        $response = $this->noteService->show($request->user_id, $id);

        return  $this->setCode($response['code'])->setMessages($response['messages'])->setData($response['data'])->customResponse();
    }



    public function update(UpdateNoteRequest $request, string $id)
    {
        $response = $this->noteService->update_note($request->validated(), $id);
        return  $this->setCode($response['code'])->setMessages($response['messages'])->setData($response['data'])->customResponse();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $response = $this->noteService->destroy($request->user_id, $id);

        return  $this->setCode($response['code'])->setMessages($response['messages'])->setData($response['data'])->customResponse();
    }
}
