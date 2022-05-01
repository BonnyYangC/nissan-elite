<div class="admin-header" id="nav-app-wrap">
    <nav class="navbar is-dark">
        <div class="navbar-brand">
            <a class="navbar-item" href="{{ env('SITE_URL') }}">
                <img src="https://destination.com.au/img/DESTINATION_REV_LOGO.png" alt="Nissan {{ config('elite.PROGRAM_SHORT_NAME') }}" width="112" height="32">
            </a>
        </div>
        <div id="menu" class="navbar-menu slideout-menu" >
            <div class="navbar-start">
                <a class="navbar-item" href="{{ route('admin.dashboard') }}">
                    Dashboard
                </a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Users Manager
                    </a>
                    <div class="navbar-dropdown is-boxed">
                        <a class="navbar-item" href="{{ route('admin.dealers_users') }}">
                            Dealer's Users
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('admin.region_staff') }}">
                            Region Staff
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('admin.admin_users') }}">
                            Admin Users
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('admin.usage') }}">
                            Site Usage
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" href="{{ route('admin.data_export', ['type' => 'historical_export']) }}">
                            Historical Export
                        </a>
                    </div>
                </div>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        Content Manager
                    </a>
                    <div class="navbar-dropdown is-boxed">
                        <a class="navbar-item" href="{{ route('admin.calendars') }}">
                            Calendar
                        </a>
                        <a class="navbar-item" href="{{ route('admin.incentives') }}">
                            Incentives
                        </a>
                        <a class="navbar-item" href="{{ route('admin.faqs') }}">
                            FAQ
                        </a>
                    </div>
                </div>

                <div class="navbar-item">
                    <el-autocomplete
                        v-model="keyword"
                        style="width: 400px;"
                        :fetch-suggestions="querySearchAsync"
                        placeholder="Find a User By: Firstname Surname"
                        @select="handleSelect"
                        :hide-loading="true"
                        :trigger-on-focus="false"
                        :select-when-unmatched="true"
                    >
                        <template slot-scope="{ item }">
                            <p class="name">${ item.firstname } ${ item.lastname } - ${ item.name }(${ item.position_code })</p>
                        </template>
                    </el-autocomplete>
                </div>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="field is-grouped">
                        <p class="control">
                            <a href="{{ route('logout') }}" class="button is-link">
                                <i class="fas fa-sign-out-alt"></i>&nbsp;
                                Logout
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </nav>

    <el-dialog
        title="Question"
        :visible.sync="dialogVisible"
        width="30%" style="z-index: 9999;">
          <span slot="footer" class="dialog-footer">
              <el-button icon="el-icon-share" type="success" @click="mockHandler">Mock</el-button>
              <el-button icon="el-icon-edit-outline" type="primary" @click="editHandler">Edit</el-button>
              <el-button icon="el-icon-close" @click="dialogVisible = false">Cancel</el-button>
          </span>
    </el-dialog>
</div>
