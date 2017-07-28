<div class="site-sidebar">
    <div class="custom-scroll custom-scroll-light">
        <ul class="sidebar-menu">
            <li class="menu-title">Navigation</li>
            <li class="with-sub">
                <a href="{{ url('admin/dashboard') }}" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="fa fa-home"></i></span>
                    <span class="s-text">Dashboard</span>
                </a>
            </li>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="ti-settings"></i></span>
                    <span class="s-text">Setting Website</span>
                </a>
                <ul>
                    <li><a href="{{ route('settings-web') }}">Setting Web</a></li>
                    <li><a href="{{ route('settings-provide-help') }}">Setting Provide Help</a></li>
                    <li><a href="{{ route('settings-get-help') }}">Setting Get Help</a></li>
                    <li><a href="{{ route('settings-profit') }}">Setting Profit</a></li>
                    <li><a href="{{ route('pages.index') }}">Setting Content</a></li>
                    <li><a href="{{ url('admin/faq') }}">Setting Faqs</a></li>
                    <li><a href="{{ url('admin/letter-of-happiness') }}">Letter Of Happiness</a></li>
                    
                    
                </ul>
            </li>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-bars"></i></span>
                    <span class="s-text">PH Transactions</span>
                </a>
                <ul>
                    <li><a href="{{ url('admin/ph') }}">Manage PH</a></li>
                    <li><a href="{{ url('admin/ph/create') }}">Create PH Manual</a></li>
                    <?php /*<li><a href="#">PH Problem</a></li>
                    <li><a href="#">PH Success</a></li>
                    <li><a href="#">PH Not Yet Pairing</a></li>
                    <li><a href="#">PH Freeze / Pause</a></li>
                    <li><a href="#">Cancelling PH </a></li>*/ ?>
                </ul>
            </li>
            
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-money"></i></span>
                    <span class="s-text">GH Transactions</span>
                </a>
                <ul>
                    <li><a href="{{ url('admin/gh') }}">Manage GH</a></li>
                    <li><a href="{{ url('admin/gh/create') }}">Create GH Manual</a></li>
                    <li><a href="{{ url('admin/gh/pending') }}">Pending GH</a></li>
                    <?php /*<li><a href="#">GH Problem</a></li>
                    <li><a href="#">GH Success</a></li>
                    <li><a href="#">GH Not Yet Pairing</a></li>
                    <li><a href="#">GH Freeze / Pause</a></li>
                    <li><a href="#">Cancelling GH </a></li>*/ ?>
                </ul>
            </li>
            <li class="with-sub">
                <a href="{{ url('admin/pair') }}" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="fa fa-heart"></i></span>
                    <span class="s-text">Manage Pairs</span>
                </a>
            </li>
            <?php /*<li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-icon"><i class="fa fa-key"></i></span>
                    <span class="s-text">RESOLVING PROBLEM</span>
                </a>
            </li>*/ ?>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-user"></i></span>
                    <span class="s-text">Member Management</span>
                </a>
                <ul>
                    <li><a href="{{ url('admin/users') }}">Active Member</a></li>
                    <li><a href="{{ url('admin/users/suspended-users') }}">Suspend Member</a></li>
                </ul>
            </li>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-trophy"></i></span>
                    <span class="s-text">Manager Management</span>
                </a>
                <ul>
                    <li><a href="{{ url('admin/managers') }}">Manager Setting</a></li>
                    <li><a href="{{ url('admin/users/upgrade-members') }}">Upgrade Member to Manager</a></li>
                    <li class="with-sub">
                        <a href="#">
                            <span class="s-text">Manage Directors</span>
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                        </a>
                        <ul>
                            <li><a href="{{ route('director-list') }}?manager_id=1">Directors</a></li>
                            <li><a href="{{ route('director-list') }}?manager_id=2">Sr. Directors</a></li>
                            <li><a href="{{ route('director-list') }}?manager_id=3">Principal Directors</a></li>
                            <li><a href="{{ route('director-list') }}?manager_id=4">Chief Directors</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-bullhorn"></i></span>
                    <span class="s-text">News Management</span>
                </a>
                <ul>
                    <li><a href="{{ url('admin/news') }}">All News</a></li>
                    <li><a href="{{ url('admin/news/create') }}">Create News</a></li>
                </ul>
            </li>
            <li class="with-sub">
                <a href="#" class="waves-effect  waves-light">
                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                    <span class="s-icon"><i class="fa fa-envelope"></i></span>
                    <span class="s-text">Messages Management</span>
                </a>
                <ul>
                    <li><a href="{{ url('admin/compose-message') }}">Compose</a></li>
                    <li><a href="{{ url('admin/inbox') }}">Inbox</a></li>
                    <li><a href="{{ url('admin/outbox') }}">Outbox</a></li>
                    <li><a href="{{ url('admin/broadcast') }}">Broadcast</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
