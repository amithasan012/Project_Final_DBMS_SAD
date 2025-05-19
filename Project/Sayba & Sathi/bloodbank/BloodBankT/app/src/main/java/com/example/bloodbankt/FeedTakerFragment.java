package com.example.bloodbankt;

import android.os.Bundle;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.FrameLayout;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.JsonArrayRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;

public class FeedTakerFragment extends Fragment {
    FrameLayout feedTaker;
    RecyclerView recyclerView;
    HashMap<String,String> hashMap;
    ArrayList<HashMap<String,String>> arrayList;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
         View myView= inflater.inflate(R.layout.fragment_feed_taker, container, false);

         recyclerView = myView.findViewById(R.id.recyclerView);
        feedTaker = myView.findViewById(R.id.feedTaker);

        arrayList = new ArrayList<>();

        fetchData();

        MyAdapter adapter = new MyAdapter();
        recyclerView.setAdapter(adapter);
        recyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        return myView;
    }

    public  class MyAdapter extends RecyclerView.Adapter<FeedTakerFragment.MyAdapter.myViewHolder>{
public  class myViewHolder extends RecyclerView.ViewHolder{
TextView list_name,list_phone,list_feedback;
    public myViewHolder(@NonNull View itemView) {
        super(itemView);
        list_feedback = itemView.findViewById(R.id.list_feedback);
        list_name = itemView.findViewById(R.id.list_name);
        list_phone = itemView.findViewById(R.id.list_phone);
    }
}
        @NonNull
        @Override
        public MyAdapter.myViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

    LayoutInflater inflater = getLayoutInflater();
    View myView = inflater.inflate(R.layout.feedback_list,parent,false);
            return new myViewHolder(myView);
        }

        @Override
        public void onBindViewHolder(@NonNull MyAdapter.myViewHolder holder, int position) {
            HashMap<String, String> item = arrayList.get(position);
            holder.list_name.setText(item.get("Name"));
            holder.list_phone.setText(item.get("Phone"));
            holder.list_feedback.setText(item.get("Feedback"));
        }

        @Override
        public int getItemCount() {
            return arrayList.size();
        }
    }
    public void fetchData() {
        String url = "https://googix.xyz/blood_db/feedbackv.php";

        RequestQueue queue = Volley.newRequestQueue(getActivity());

        JsonArrayRequest jsonArrayRequest = new JsonArrayRequest(Request.Method.GET, url, null,
                response -> {
                    arrayList.clear();
                    for (int i = 0; i < response.length(); i++) {
                        try {
                            JSONObject obj = response.getJSONObject(i);
                            hashMap = new HashMap<>();
                            hashMap.put("Name", obj.optString("name", "N/A"));
                            hashMap.put("Phone", obj.optString("phone", "N/A"));
                            hashMap.put("Feedback", obj.optString("feedback", "N/A"));

                            arrayList.add(hashMap);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                    recyclerView.getAdapter().notifyDataSetChanged();
                },
                error -> {
                    error.printStackTrace();
                });

        queue.add(jsonArrayRequest);
    }
}