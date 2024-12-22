<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\FileRepository;
use App\Repository\LeadRepository;
use App\Repository\LoggingRepository;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    private LeadRepository $leadRepository;
    private LoggingRepository $loggingRepository;
    private FileRepository $fileRepository;
    public function __construct(
        LeadRepository $leadRepository,
        LoggingRepository $loggingRepository,
        FileRepository $fileRepository
    )
    {
        $this->leadRepository = $leadRepository;
        $this->loggingRepository = $loggingRepository;
        $this->fileRepository = $fileRepository;
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request) {
        $content = [];
        switch ($request->get('view')) {
            case 'order_event':
                $content = $this->leadRepository->list();
                break;
            case 'logs':
                $content = $this->loggingRepository->list();
                break;
            case 'demo':
                if ($request->get('key')) {
                    $event = $this->leadRepository->findByKey($request->get('key'));
                    $banner = $this->fileRepository->getKey($event['data']['image']);
                    $content = [
                        'event' => $event,
                        'banner' => $banner
                    ];
                }
                break;
        }
        return view('admin.page', [
            'page' => $request->get('view'),
            'content' => $content
        ]);
    }
}
