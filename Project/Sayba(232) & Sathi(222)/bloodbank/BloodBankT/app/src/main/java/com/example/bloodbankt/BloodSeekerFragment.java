package com.example.bloodbankt;

import android.app.AlertDialog;
import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.Spinner;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

public class BloodSeekerFragment extends Fragment {

    EditText bseeker_name,bseeker_phone,hospital,reason,requiredB_group,amountn;
    Button SignInS,ShowlistS;
    ProgressBar progressBar;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View myView = inflater.inflate(R.layout.fragment_blood_seeker, container, false);

bseeker_name = myView.findViewById(R.id.bseeker_name);
        bseeker_phone = myView.findViewById(R.id.bseeker_phone);
        hospital = myView.findViewById(R.id.hospital);
        reason = myView.findViewById(R.id.reason);
        requiredB_group = myView.findViewById(R.id.requiredB_group);
        amountn = myView.findViewById(R.id.amountn);
        SignInS = myView.findViewById(R.id.SignInS);
        ShowlistS = myView.findViewById(R.id.ShowlistS);
        progressBar = myView.findViewById(R.id.progressBar);


        SignInS.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {



                try {
                    String name = URLEncoder.encode(bseeker_name.getText().toString().trim(), "UTF-8");
                    String phone = URLEncoder.encode(bseeker_phone.getText().toString().trim(), "UTF-8");
                    String hospital_name = URLEncoder.encode(hospital.getText().toString().trim(), "UTF-8");
                    String re_ason = URLEncoder.encode(reason.getText().toString().trim(), "UTF-8");
                    String blood_group = URLEncoder.encode(requiredB_group.getText().toString().trim(), "UTF-8");
                    String amount = URLEncoder.encode(amountn.getText().toString().trim(), "UTF-8");

                    String url = "https://googix.xyz/blood_db/blood_seeker.php?" +
                            "n=" + name +
                            "&p=" + phone +
                            "&r=" + re_ason +
                            "&h=" + hospital_name +
                            "&b=" + blood_group +
                            "&a=" + amount;

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
        ShowlistS.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                FragmentManager fm = getActivity().getSupportFragmentManager();
                FragmentTransaction ft = fm.beginTransaction();
                ft.replace(R.id.blood_seeker,new SeekerList());
                ft.commit();
            }
        });
        return myView; // ✅ return only after everything is done
    }



}