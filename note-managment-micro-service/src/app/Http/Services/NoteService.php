<?php

namespace App\Http\Services;

use App\Jobs\AuthNoteQueueJob;
use App\Models\Building;
use App\Models\Page;
use App\Models\Album;
use App\Repositories\AlbumRepository;
use App\Repositories\MediaRepository;
use App\Repositories\SeoSectionRepository;
use App\Repositories\NoteRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Illuminate\Support\Facades\Queue;

class NoteService extends _Service
{
    public function __construct(
        protected NoteRepository $noteRepository,
    ) {
        $this->noteRepository = $noteRepository;
    }


    protected function findAll($user_id)
    {
        try {
            $notes = $this->noteRepository->findBy(['user_id'=>$user_id]);
            return returnData(
                [],
                Response::HTTP_OK,
                compact('notes'),
                ['All Notes']
            );
        } catch (\Exception $e) {
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }
    }
    protected function create($data)
    {
        try {
            $note = $this->noteRepository->create($data->toArray());
            return returnData(
                [],
                Response::HTTP_OK,
                compact('note'),
                ['Registered Successfully']
            );
        } catch (\Exception $e) {
            dd($e);
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }
    }
    protected function update_note($data, $note_id)
    {
        try {
            $note = $this->noteRepository->find($note_id);
            if(!$note){
                return returnData(
                    [],
                    Response::HTTP_NOT_FOUND,
                    [],
                    ['no notes found']
                );

            }

            if($note->user_id !== $data['user_id']){
                return returnData(
                    [],
                    Response::HTTP_UNAUTHORIZED,
                    [],
                    ['this note not belongs to this user']
                );
            }
             $this->noteRepository->update($data->toArray(), $note_id);
            return returnData(
                [],
                Response::HTTP_OK,
                compact('note'),
                ['Updated Successfully']
            );
        } catch (\Exception $e) {
            dd($e);
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }
    }
    protected function show($user_id,$note_id)
    {
        try {
            $note = $this->noteRepository->find($note_id);
            if(!$note){
                return returnData(
                    [],
                    Response::HTTP_NOT_FOUND,
                    [],
                    ['no notes found']
                );

            }
            if($note->user_id !== $user_id){
                return returnData(
                    [],
                    Response::HTTP_UNAUTHORIZED,
                    [],
                    ['this note not belongs to this user']
                );
            }



            return returnData(
                [],
                Response::HTTP_OK,
                compact('note'),
                ['Note Details']
            );
        } catch (Exception $e) {
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }
    }
    protected function destroy($user_id,$note_id)
    {
        try {
            $note = $this->noteRepository->find($note_id);
            if(!$note){
                return returnData(
                    [],
                    Response::HTTP_NOT_FOUND,
                    [],
                    ['no notes found']
                );

            }
            if($note->user_id !== $user_id){
                return returnData(
                    [],
                    Response::HTTP_UNAUTHORIZED,
                    [],
                    ['this note not belongs to this user']
                );
            }
            $this->noteRepository->delete( $note_id);

            return returnData(
                [],
                Response::HTTP_OK,
                [],
                ['Delete Successfully']
            );
        } catch (Exception $e) {
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }
    }
}
