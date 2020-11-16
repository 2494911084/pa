<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Word;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Models\Project;

class WordController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Word('project'), function (Grid $grid) {
            ## 表格边框模式
            $grid->withBorder();
            ## 快捷搜索
            $grid->quickSearch('title');

            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('word_url')->link(function($value){
                return config('app.url') .  '/uploads/' . $value;
            });
            $grid->column('type')->display(function(){
                switch ($this->type) {
                    case 1:
                        return '项目文件';
                        break;
                    case 2:
                        return '其他文件';
                        break;
                }
            });
            $grid->column('project.name','项目');
            $grid->column('created_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->like('title');
                $filter->equal('project_id', '项目')->select(Project::all()->pluck('name', 'id'));

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
        return Show::make($id, new Word(), function (Show $show) {
            $show->field('id');
            $show->field('project_id');
            $show->field('title');
            $show->field('word_url');
            $show->field('type');
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
        return Form::make(new Word(), function (Form $form) {
            $form->display('id');

            $form->radio('type')
            ->when(1, function (Form $form) {
                $form->select('project_id', '项目')->options(Project::all()->pluck('name', 'id'))->default(0);
            })
            ->when(2, function (Form $form) {
            })
            ->options([
                1 => '项目文件',
                2 => '其他文件',
            ])
            ->default(1);

            $form->text('title')->required();
            $form->file('word_url')
                    ->uniqueName()
                    ->required();

            $form->display('created_at');
            $form->display('updated_at');

            $form->saving(function(Form $form){
                if ($form->type == 2) {
                    $form->project_id = 0;
                }
                if ($form->project_id == 0) {
                    $form->type = 2;
                    $form->project_id = 0;
                }
            });
        });
    }
}
