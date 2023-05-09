@extends('layouts.app')
@section('content')
  <div class="container">
      <nav class="breadcrumb" style="background-color: #e9ecef; padding: 8px 15px;">
        <a href="/" class="breadcrumb-item"> Forum Categories</a>
        <span class="breadcrumb-item active">{{$category->title}}</span>
      </nav>

      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <!-- Category one -->
            <div class="col-lg-12">
              <!-- second section  -->
              <h4 class="text-white bg-info mb-0 p-4 rounded-top">
                {{$category->title}}
              </h4>
              <table
                class="table table-striped table-responsive table-bordered mb-xl-0"
              >
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Forum</th>
                    <th scope="col">Topics</th>
                    {{-- <th scope="col">Posts</th> --}}
                    {{-- <th scope="col">Latest Post</th> --}}
                  </tr>
                </thead>
                <tbody>
                  @if (count($category->forums) > 0)
                  @foreach ($category->forums as $forum)
                     <tr>
                    <td>
                      <h3 class="h5">
                        <a href="{{route('forum.overview', $forum->id)}}" class="text-uppercase">{{$forum->title}}</a>
                      </h3>
                      <p class="mb-0">
                        {!!$forum->desc!!}
                      </p>
                    </td>
                    {{-- <td><div>{{$forum->discussion}}</div></td> --}}
                    <td><div>{{ $forum->discussions ? $forum->discussions->count() : 0 }}</div></td>
                    {{-- <td>
                      <h4 class="h6 font-weight-bold mb-0">
                        <a href="#">Post name</a>
                      </h4>
                      <div><a href="#">Author name</a></div>
                      <div>06/07/ 2021 20:04</div>
                    </td> --}}
                  </tr>
                  @endforeach
                    @else
                  <h4>No Forums In This Category</h4>
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
            <aside>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Members Online</h4>
                        <ul class="list-unstyled mb-0">
                            @if (count($users_online) > 0)
                                @foreach ($users_online as $user)
                                    <li><a href="{{route('client.user_profile', $user->id)}}">{{ $user->name }} <span
                                                class="badge badge-pill badge-success">Online</span></a></li>
                                @endforeach
                            @else
                                <p>No User Online</p>
                            @endif
                        </ul>
                    </div>
                    <div class="card-footer">
                        {{-- <dl class="row">
                  <dt class="col-8 mb-0">Total:</dt>
                  <dd class="col-4 mb-0">10</dd>
                </dl>
                <dl class="row">
                  <dt class="col-8 mb-0">Members:</dt>
                  <dd class="col-4 mb-0">10</dd>
                </dl>
                <dl class="row">
                  <dt class="col-8 mb-0">Guests:</dt>
                  <dd class="col-4 mb-0">3</dd>
                </dl> --}}
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">All Members</h4>
                        <ul class="list-unstyled mb-0">
                            @if (count($few_users) > 0)
                                @foreach ($few_users as $user)
                                    <li><a href="{{route('client.user_profile', $user->id)}}">{{ $user->name }}</a></li>
                                @endforeach
                                @else
                                <p>No Members Found</p>
                            @endif
                            <li><a href="{{route('client.users')}}">View All...</a></li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        {{-- <dl class="row">
                  <dt class="col-8 mb-0">Total:</dt>
                  <dd class="col-4 mb-0">10</dd>
                </dl>
                <dl class="row">
                  <dt class="col-8 mb-0">Members:</dt>
                  <dd class="col-4 mb-0">10</dd>
                </dl>
                <dl class="row">
                  <dt class="col-8 mb-0">Guests:</dt>
                  <dd class="col-4 mb-0">3</dd>
                </dl> --}}
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Members Statistics</h4>
                        <dl class="row">
                            <dt class="col-8 mb-0">Total Categories:</dt>
                            <dd class="col-4 mb-0">{{ $totalCategories }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-8 mb-0">Total Forums:</dt>
                            <dd class="col-4 mb-0">{{ $forumsCount }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-8 mb-0">Total Topics:</dt>
                            <dd class="col-4 mb-0">{{ $topicsCount }}</dd>
                        </dl>
                        <dl class="row">
                            <dt class="col-8 mb-0">Total members:</dt>
                            <dd class="col-4 mb-0">{{ $totalMembers }}</dd>
                        </dl>
                    </div>
                    <div class="card-footer">
                        <div>Newest Member</div>
                        @if ($newest)
                        <div><a href="#">{{$newest->name}}</a></div>
                            @else
                            <div><p>No users yet!</p></div>
                        @endif
                    </div>
                </div>
            </aside>
        </div>
    </div>
      </div>
    </div>
@endsection