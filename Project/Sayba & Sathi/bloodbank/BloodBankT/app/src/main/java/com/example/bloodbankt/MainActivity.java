package com.example.bloodbankt;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.MenuItem;
import android.view.View;
import android.widget.FrameLayout;
import android.widget.Toast;
import android.widget.Toolbar;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.Insets;
import androidx.core.view.GravityCompat;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import com.google.android.material.appbar.MaterialToolbar;
import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.navigation.NavigationBarView;
import com.google.android.material.navigation.NavigationView;

public class MainActivity extends AppCompatActivity {
FrameLayout frameLayout;
NavigationView navigationView;
BottomNavigationView bnv;
MaterialToolbar toolbar;
DrawerLayout drawerLayout;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_main);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.drawerLayout), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        frameLayout = findViewById(R.id.frameLayout);
        navigationView = findViewById(R.id.navigationView);
        bnv = findViewById(R.id.bnv);
        toolbar = findViewById(R.id.toolbar);
        drawerLayout = findViewById(R.id.drawerLayout);
//====================drawer open start=============================================================
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                MainActivity.this,drawerLayout,toolbar,R.string.Open_drawer,R.string.Close_drawer);
        drawerLayout.addDrawerListener(toggle);
//====================drawer open end=============================================================
// ==================== bottom nav items onclick start ====================================================
        bnv.setOnItemSelectedListener(new NavigationBarView.OnItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                if(item.getItemId()== R.id.feedback)
                {
                    frameLayout.setVisibility(View.VISIBLE);
                    FragmentManager fm = getSupportFragmentManager();
                    FragmentTransaction ft = fm.beginTransaction();
                    ft.replace(R.id.frameLayout,new FeedFragment());
                    ft.commit();

                }
                if(item.getItemId()== R.id.login)
                {
                    frameLayout.setVisibility(View.VISIBLE);
                    FragmentManager fm = getSupportFragmentManager();
                    FragmentTransaction ft = fm.beginTransaction();
                    ft.replace(R.id.frameLayout,new LoginFragment());
                    ft.commit();

                }
                if(item.getItemId()== R.id.home)
                {
                    drawerLayout.setVisibility(View.VISIBLE);
                    frameLayout.setVisibility(View.GONE);
                    FragmentManager fm = getSupportFragmentManager();
                    FragmentTransaction ft = fm.beginTransaction();
                    ft.replace(R.id.frameLayout,new FeedFragment());
                    ft.commit();

                }
                return true;
            }
        });
        // ==================== bottom nav items onclick end============================================
        //=====================drawer items onclick start=================================================
        navigationView.setNavigationItemSelectedListener(new NavigationView.OnNavigationItemSelectedListener() {
            @Override
            public boolean onNavigationItemSelected(@NonNull MenuItem item) {
                if(item.getItemId()==R.id.blood_doner)
                {
                    frameLayout.setVisibility(View.VISIBLE);
                    FragmentManager fm = getSupportFragmentManager();
                    FragmentTransaction ft = fm.beginTransaction();
                    ft.replace(R.id.frameLayout,new BloodDonerFragment());
                    ft.commit();

                  drawerLayout.closeDrawer(GravityCompat.START);
                }
                if(item.getItemId()==R.id.blood_seeker)
                {
                    frameLayout.setVisibility(View.VISIBLE);
                    FragmentManager fm = getSupportFragmentManager();
                    FragmentTransaction ft = fm.beginTransaction();
                    ft.replace(R.id.frameLayout,new BloodSeekerFragment());
                    ft.commit();

                    drawerLayout.closeDrawer(GravityCompat.START);
                }
                return false;
            }
        });
        //=====================drawer items onclick end=================================================

    }
}