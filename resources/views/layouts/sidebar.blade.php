<div class="list-group">
    <a href="{{ route('home') }}" class="list-group-item {{ url()->current()==route('home')? 'active' :''}}" >
      <i class="fas fa-home mr-2"></i><span>一覧表示</span>
    </a>
    <a href="{{ route('post.create') }}" class="list-group-item {{ url()->current()==route('post.create')? 'active':'' }}">
        <i class="fas fa-quidditch mr-2"></i><span>新規登録</span>
    </a>
    <a href="{{ route('home.mypost') }}" class="list-group-item {{ url()->current()==route('home.mypost')? 'active':'' }}">
        <i class="far fa-list-alt mr-2"></i><span>自分の投稿</span>
    </a>
    <a href="{{ route('home.mycomment') }}" class="list-group-item {{ url()->current()==route('home.mycomment')? 'active':'' }}">
        <i class="fas fa-comments mr-2"></i><span>コメントした投稿</span>
    </a>
    
    @can('admin')
    <a href="{{ route('profile.index') }}" class="list-group-item {{ url()->current()==route('profile.index')? 'active':'' }}">
        <i class="far fa-address-book mr-2"></i><span>ユーザーアカウント</span>
    </a>
    @endcan
</div>
<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/all.js"></script>