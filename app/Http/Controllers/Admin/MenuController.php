<?php

namespace App\Http\Controllers\Admin;

use App\Helper\BreadcrumbsRegister;
use App\DataTables\Admin\MenuDataTable;
use App\Http\Requests\Admin;
use App\Http\Requests\Admin\CreateMenuRequest;
use App\Http\Requests\Admin\UpdateMenuRequest;
use App\Repositories\Admin\MenuRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

class MenuController extends AppBaseController
{
    /** ModelName */
    private $ModelName;

    /** BreadCrumbName */
    private $BreadCrumbName;

    /** @var  MenuRepository */
    private $menuRepository;

    public function __construct(MenuRepository $menuRepo)
    {
        $this->menuRepository = $menuRepo;
        $this->ModelName = 'menus';
        $this->BreadCrumbName = 'Menu';
    }

    /**
     * Display a listing of the Menu.
     *
     * @param MenuDataTable $menuDataTable
     * @return Response
     */
    public function index(MenuDataTable $menuDataTable)
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return $menuDataTable->render('admin.menus.index');

//        $menus = $this->menuRepository->all();
//        if (empty($menus)) {
//            Flash::error('Car not found');
//            return redirect(route('admin.menus.index'));
//        }
//        return view('admin.menus.index')->with('menus', $menus);

    }

    /**
     * Show the form for creating a new Menu.
     *
     * @return Response
     */
    public function create()
    {
        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName);
        return view('admin.menus.create');
    }

    /**
     * Store a newly created Menu in storage.
     *
     * @param CreateMenuRequest $request
     *
     * @return Response
     */
    public function store(CreateMenuRequest $request)
    {
        $input = $request->all();

        $menu = $this->menuRepository->create($input);

        Flash::success('Menu saved successfully.');

        return redirect(route('admin.menus.index'));
    }

    /**
     * Display the specified Menu.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $menu = $this->menuRepository->findWithoutFail($id);

        if (empty($menu)) {
            Flash::error('Menu not found');

            return redirect(route('admin.menus.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $menu);
        return view('admin.menus.show')->with('menu', $menu);
    }

    /**
     * Show the form for editing the specified Menu.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $menu = $this->menuRepository->findWithoutFail($id);

        if (empty($menu)) {
            Flash::error('Menu not found');

            return redirect(route('admin.menus.index'));
        }

        BreadcrumbsRegister::Register($this->ModelName,$this->BreadCrumbName, $menu);
        return view('admin.menus.edit')->with('menu', $menu);
    }

    /**
     * Update the specified Menu in storage.
     *
     * @param  int              $id
     * @param UpdateMenuRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMenuRequest $request)
    {
        $menu = $this->menuRepository->findWithoutFail($id);

        if (empty($menu)) {
            Flash::error('Menu not found');

            return redirect(route('admin.menus.index'));
        }

        $menu = $this->menuRepository->update($request->all(), $id);

        Flash::success('Menu updated successfully.');

        return redirect(route('admin.menus.index'));
    }

    /**
     * Remove the specified Menu from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $menu = $this->menuRepository->findWithoutFail($id);

        if (empty($menu)) {
            Flash::error('Menu not found');

            return redirect(route('admin.menus.index'));
        }

        $this->menuRepository->delete($id);

        Flash::success('Menu deleted successfully.');

        return redirect(route('admin.menus.index'));
    }

    public function statusChange(Request $request, $id)
    {
        $input = $request->all();
        $menu = $this->menuRepository->findWithoutFail($id);

        if (empty($menu)) {
            Flash::error('Menu not found');
            return redirect(route('admin.menus.index'));
        }

        if($menu['status'] == 1){
            $status_data['status'] = 0;
        }else{
            $status_data['status'] = 1;
        }

        $this->menuRepository->update($status_data, $id);
//        (dd($status));

        Flash::success('Status Updated.');
        return response('Success');
    }

    public function update_channel_position(Request $request)
    {
        $responce['msg'] = false;
        $input = $request->all();

        if (!empty($input['channelId']) && !empty($input['channelPosition']) && !empty($input['prevChannelId']) && !empty($input['prevChannelPosition'])) {
            //TODO: current channel
            $ch1_id = $input['channelId']; //18
            $ch1_position['sort_by'] = $input['channelPosition']; //18

            //TODO: Previous channel
            $ch2_id = $input['prevChannelId']; //19
            $ch2_position['sort_by'] = $input['prevChannelPosition']; //19

            //TODO: Swapping
            $channel1 = $this->menuRepository->update($ch1_position, $ch2_id);
            $channel2 = $this->menuRepository->update($ch2_position, $ch1_id);

//            dd($channel1);

            if ($channel1 && $channel2) {
                $responce['msg'] = true;
            }
        }
        return $responce;
    }

}
