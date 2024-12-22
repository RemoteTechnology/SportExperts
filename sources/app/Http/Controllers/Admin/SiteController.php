<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Constants\EnumConstants\EntityLeadsEnum;
use App\Domain\Constants\EnumConstants\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Repository\FileRepository;
use App\Repository\LeadRepository;
use App\Repository\LoggingRepository;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    private LeadRepository $leadRepository;
    private LoggingRepository $loggingRepository;
    private FileRepository $fileRepository;
    private UserRepository $userRepository;

    public function __construct(
        LeadRepository $leadRepository,
        LoggingRepository $loggingRepository,
        FileRepository $fileRepository,
        UserRepository $userRepository,
    )
    {
        $this->leadRepository = $leadRepository;
        $this->loggingRepository = $loggingRepository;
        $this->fileRepository = $fileRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request) {
        $content = [];
        switch ($request->get('view')) {
            case 'order_event':
                $content = $this->leadRepository->list(['entity' => EntityLeadsEnum::EVENT_LEAD]);
                break;
            case 'logs':
                $content = $this->loggingRepository->list();
                break;
            case 'demo':
                if ($request->get('key')) {
                    $event = $this->leadRepository->findByKey($request->get('key'));
                    $banner = $this->fileRepository->getKey($event['data']['image']);
                    $option = function () use($request): array {
                        foreach ($this->leadRepository->list(['entity' => EntityLeadsEnum::OPTION_LEAD]) as $item) {
                            if ($item['data']['key'] === $request->get('key')) {
                                $options[] = $item;
                            }
                        }

                        return isset($options) ? $options : [];
                    };
                    $content = [
                        'event' => $event,
                        'banner' => $banner,
                        'options' => $option()
                    ];
                }
                break;
            case 'users':
                $content = new UserCollection($this->userRepository->findByRole([RoleEnum::ADMIN, RoleEnum::ADMIN_ATHLETE]));
                $content = $content->resource;
                break;
        }
        return view('admin.page', [
            'page' => $request->get('view'),
            'content' => $content
        ]);
    }
}
