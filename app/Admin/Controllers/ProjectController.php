<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Project;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class ProjectController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Project(), function (Grid $grid) {
            ## 表格边框模式
            $grid->withBorder();
            ## 快捷搜索
            $grid->quickSearch('name');

            $grid->column('id')->sortable();
            $grid->column('name');
            $grid->column('mininame');
            $grid->column('work_date', '预计时间')->display(function(){
                return $this->work_start_date . ' | ' . $this->work_end_date;
            });
            $grid->status()->select([
                0 => '进行中',
                1 => '已完成',
            ]);
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('name');
                $filter->like('mininame');

            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Project(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            $show->field('mininame');
            $show->field('work_start_date');
            $show->field('work_end_date');
            $show->field('status');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Project(), function (Form $form) {
            $form->display('id');
            $form->text('name')->required();
            $form->text('mininame')->required();
            $form->dateRange('work_start_date', 'work_end_date', '项目周期')->required();
            $form->select('status')->options([0=>'进行中', 1=>'已完成'])->required();

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
