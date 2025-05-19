package com.example.bloodbankt;

import android.app.AlertDialog;
import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ProgressBar;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.material.appbar.MaterialToolbar;

import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;

public class FeedFragment extends Fragment {
Button submitFeedback,showFeedback;
EditText feedback,feedback_phone,feedback_name;
ProgressBar progressBAr;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View myView = inflater.inflate(R.layout.fragment_feed, container, false);

        submitFeedback = myView.findViewById(R.id.submitFeedback);
        feedback = myView.findViewById(R.id.feedback);
        feedback_phone = myView.findViewById(R.id.feedback_phone);
        feedback_name = myView.findViewById(R.id.feedback_name);
        progressBAr = myView.findViewById(R.id.progressBAr);
        showFeedback = myView.findViewById(R.id.showFeedback);

        submitFeedback.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                try {
                    String name = URLEncoder.encode(feedback_name.getText().toString().trim(), "UTF-8");
                    String phone = URLEncoder.encode(feedback_phone.getText().toString().trim(), "UTF-8");
                    String f_feedback = URLEncoder.encode(feedback.getText().toString().trim(), "UTF-8");

                    String url = "https://googix.xyz/blood_db/feedbacks.php?" +
                            "n=" + name +
                            "&p=" + phone +
                            "&f=" + f_feedback;

                    StringRequest stringRequest = new StringRequest(Request.Method.GET, url,
                            response -> new AlertDialog.Builder(getActivity())
                                    .setTitle("Server Response")
                                    .setMessage(response)
                                    .show(),
                            error -> {
                                error.printStackTrace();
                            });

                    RequestQueue queue = Volley.newRequestQueue(getActivity());
                    queue.add(stringRequest);

                } catch (UnsupportedEncodingException e) {
                    e.printStackTrace();
                }
            }
        });
        showFeedback.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                FragmentManager fm = getActivity().getSupportFragmentManager();
                FragmentTransaction ft = fm.beginTransaction();
                ft.replace(R.id.fragment_feed,new FeedTakerFragment());
                ft.commit();
            }
        });
        return myView;
    }
}