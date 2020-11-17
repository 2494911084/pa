<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Project;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Widgets\Markdown;
use App\Admin\Controllers\PreviewCode;
use Dcat\Admin\Layout\Content;

class ProjectController extends AdminController
{
    use PreviewCode;

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
            $grid->column('date_length');
            $grid->xuqiu
            ->display('查看') // 设置按钮名称
            ->modal(function ($modal) {
                // 设置弹窗标题
                $modal->title($this->name);

                return new Card(null, $this->xuqiu);
            });

            $grid->jindu->progressBar();
            $grid->column('work_end_date');
            $grid->status()->select([
                0 => '进行中',
                1 => '已完成',
            ], true);

            $grid->column('jjdj', '紧急程度')->display(function(){
                if ($this->status == 0) {
                    return '<span class="badge" style="background:#ea5455">紧急</span>';
                } else {
                    return '<span class="badge" style="background:#21b978">正常</span>';
                }
            });

            $grid->column('created_at');

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                // append一个操作
                $actions->append('<a href="/admin/word?project_id='.$actions->getKey().'">文档</a>');
            });

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
            $form->text('date_length');
            $form->date('work_end_date')->required();
            $form->slider('jindu')->options(['max' => 100, 'min' => 0, 'step' => 1, 'postfix' => '%']);
            $form->select('status')->options([0=>'进行中', 1=>'已完成'])->required();
            $form->editor('xuqiu');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
