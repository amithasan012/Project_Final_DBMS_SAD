package com.example.bloodbankt;

import android.app.AlertDialog;
import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

public class LoginFragment extends Fragment {
ProgressBar progressBar;
Button submitInformation;
EditText login_name,login_phone,login_group,login_address,login_gender;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
      View myView =  inflater.inflate(R.layout.fragment_login, container, false);
      progressBar = myView.findViewById(R.id.progressBar);
        submitInformation = myView.findViewById(R.id.submitInformation);
        login_name = myView.findViewById(R.id.login_name);
        login_phone = myView.findViewById(R.id.login_phone);
        login_group = myView.findViewById(R.id.login_group);
        login_address = myView.findViewById(R.id.login_address);
        login_gender = myView.findViewById(R.id.login_gender);

        submitInformation.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                try {
                    String name = URLEncoder.encode(login_name.getText().toString().trim(), "UTF-8");
                    String phone = URLEncoder.encode(login_phone.getText().toString().trim(), "UTF-8");
                    String group = URLEncoder.encode(login_group.getText().toString().trim(), "UTF-8");
                    String address= URLEncoder.encode(login_address.getText().toString().trim(), "UTF-8");
                    String gender = URLEncoder.encode(login_gender.getText().toString().trim(), "UTF-8");

                    String url = "https://googix.xyz/blood_db/login.php?" +
                            "n=" + name +
                            "&p=" + phone +
                            "&b=" + group +
                            "&a=" + address +
                            "&g=" + gender;

                    progressBar.setVisibility(View.VISIBLE);

                    StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                            response -> new AlertDialog.Builder(getActivity())
                                    .setTitle("Server Response")
                                    .setMessage(response)
                                    .show(),

                            error -> {
                                error.printStackTrace();
                                progressBar.setVisibility(View.GONE);
                            });

                    RequestQueue queue = Volley.newRequestQueue(getActivity());
                    queue.add(stringRequest);

                } catch (UnsupportedEncodingException e) {
                    e.printStackTrace();
                }
            }
        });


        return myView;
    }
}