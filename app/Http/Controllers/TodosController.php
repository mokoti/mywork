<?php
/**
 * 
 */
class TodosController extends BaseController {

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        // beforeフィルタをインストールする
        $this->beforeFilter(
            '@existsFilter',
            ['on' => ['post', 'put']]    
        );
    }
    
    /**
     * URLパラメータidの存在をチェック
     */
    public function existsFilter()
    {
        Debugbar::info(__METHOD__.'called.');
        
        $id = Route::input('id');
        if($id)
        {
            Debugbar("todo id(${id}) checking...");
            if(! Todo::exists($id)){
                Debugbar::error("Nothing!");
                App::abort(404);
            }
            Debugbar::info("Exists!");
        }
        else {
            Debugbar::info("URL didnt contain $id.");
        }
    }

    /**
     * Todoリストページを表示する
     */
    public function index() {

        // 3つのグループデータを取得する
        // 未完了リストを取得する
        {
            $query = Todo::query()->select('*')->where('status', '=', Todo::STATUS_INCOMPLETE)->orderBy('updated_at', 'desc');

            $incompleteTodos = $query->get();
        }

        // 完了リストを取得する
        $completedTodos = Todo::whereStatus(Todo::STATUS_COMPLETED)->orderBy('completed_at'. 'desc')->get();
        
        // 削除済みリストを取得する
        $trashedTodos = Todo::onlyTrashed()->get();

        // ビューを生成する
        return View::make('pages.todos.index', [
            'incompleteTodos' => $incompleteTodos,
            'completedTodos'  => $completedTodos,
            'trashedTodos'    => $trashedTodos
        ]);
    }

    /**
     * 新規TODOを追加する
     */
    public function store() {
        // バリデーションルールの定義
        $rules = [
            'title' => 'required|min:3|max:255', // titleは必須で3文字以上255字以内
        ];
        
        // フォームの入力データを項目名を指定して取得する
        $input = Input::only(['title']);

        // バリデーターを生成する
        $validator = Validator::make($input, $rules);

        // バリデーション実行
        if ($validator->fails()){
            return Redirect::route('todos.index')->withErrors($validator)->withInput();
        }

        // Todoデータを作成する(SQL発行)
        $todo = Todo::create([
            'title'  => $input['title'],
            'status' => Todo::STATUS_INCOMPLETE,
        ]);
     
        // リストページにリダイレクトする
       return Redirect::route('todos.index');
    }

    /**
     * TODOを更新する
     */
    public function update($id) {

        // TODOモデルを取得する
        $todo = Todo::find($id);

        // バリデーションルールの定義
        $rules = [
            'title'  => 'required|min:3|max:255',
            'status' => ['required', 'numeric', 'min:1', 'max:2'],
            'dammy'  => '', // ルールを指定しないとオプション扱いできる
        ];

        // 入力データを取得する
        $input = Input::only(array_keys($rules));
        Debugbar::info(print_r($input, true));

        // バリデーション実行
        $validator = Validator::make($input, $rules);
        if ($validator->fails()){
            return Redirect::route('todos.index')->withErrors($validator)->withInput();
        }

        // titleが指定されていたら
        if ($input['title'] !== null){
            $todo->fill([
                'title' => $input['title'],
            ]);
        }

        // statusが指定されていたら
        if ($input['status'] !== null){
            $todo->fill([
                'status'       => $input['status'],
                'completed_at' => $input['status'] == Todo::STATUS_COMPLETED ? Carbon::now() : null,
            ]);
        }
        
        // データを更新する(SQL発行)
        $todo->save();

        // リストページにリダイレクトする
        return Redirect::route('todos.index');
    }

    /**
     * タイトル更新
     *
     * ページ更新がない？ためAjax通信で対応する
     */
    public function ajaxUpdateTitle($id)
    {
        // TODOモデルの取得
        $todo = Todo::find($id);

        // バリデーションルルールの定義
        $rules = [
           'title' => 'required|min:3|max:255',
       ];

        // 入力データを取得
        $input = Input::only['title'];

        // バリデーション実行
        $validator = Validator::make($input, $rules);
        if ($validator->fails()){
            return Response::json([
                'result' => 'NG',
                'errors' => $validator->errors()
            ], 400);
        }

        // titleカラムを更新
        $todo->fill([
            'title' => $input['title'],
        ]); 

        // データを更新する(SQL発行) 
        $todo->save());

        // Ajaxレスポンスを返す
        return Response::json(['result' => 'OK'], 200);
    }

    /**
     * Todoを削除する
     */
    public function delete($id) {

        // Todoモデルの取得
        $todo = Todo::find($id);

        // データの削除
        $todo->delete();

        // リストページへリダイレクト
        return Redirect::route('todos.index');
    }
    
    /**
     * Todoの復元
     */
    public function restore($id)
    {
        // 削除されたTodoモデルを取得
        $todo = Todo::onlyTrashed()->find($id);

        // データの復元
        $todo->restore();

        // リストページへリダイレクト
        return Redirect::route('todos.index');
    }

}
/* End of file TodosController.php */

