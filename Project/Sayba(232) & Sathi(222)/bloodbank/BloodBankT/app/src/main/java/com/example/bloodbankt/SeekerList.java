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

public class SeekerList extends Fragment {

RecyclerView recyclerView;
FrameLayout seekerList;
    HashMap<String,String> hashMap;
    ArrayList<HashMap<String,String>> arrayList;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        View myView=  inflater.inflate(R.layout.fragment_seeker_list2, container, false);

        recyclerView = myView.findViewById(R.id.recyclerView);
        seekerList = myView.findViewById(R.id.seekerList);

        arrayList = new ArrayList<>();

        fetchData();
        MyAdapter adapter = new MyAdapter();
        recyclerView.setAdapter(adapter);
        recyclerView.setLayoutManager(new LinearLayoutManager(getActivity()));
        return myView;
    }
    public class MyAdapter extends RecyclerView.Adapter<SeekerList.MyAdapter.myViewHolder>{
public class myViewHolder extends RecyclerView.ViewHolder{
TextView name,phone,reason,hospital,bloodGroup,amount;
    public myViewHolder(@NonNull View itemView) {
        super(itemView);
        name = itemView.findViewById(R.id.name);
        phone = itemView.findViewById(R.id.phone);
        reason = itemView.findViewById(R.id.reason);
        hospital = itemView.findViewById(R.id.hospital);
        bloodGroup = itemView.findViewById(R.id.bloodGroup);
        amount = itemView.findViewById(R.id.amount);

    }
}
        @NonNull
        @Override
        public SeekerList.MyAdapter.myViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {

            LayoutInflater inflater = LayoutInflater.from(parent.getContext());
            View myView = inflater.inflate(R.layout.item_seeker,parent,false);
            return new myViewHolder(myView);
        }

        @Override
        public void onBindViewHolder(@NonNull myViewHolder holder, int position) {
            HashMap<String, String> item = arrayList.get(position);
            holder.name.setText(item.get("Name"));
            holder.phone.setText(item.get("Phone"));
            holder.hospital.setText(item.get("Hospital"));
            holder.reason.setText(item.get("Reason"));
            holder.bloodGroup.setText(item.get("BloodGroup"));
            holder.amount.setText(item.get("Amount"));
        }

        @Override
        public int getItemCount() {
            return arrayList.size();
        }
    }
    public void fetchData() {
        String url = "https://googix.xyz/blood_db/sign_in.php";

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
                            hashMap.put("Hospital", obj.optString("hospital", "N/A"));
                            hashMap.put("Reason", obj.optString("reason", "N/A"));

                            hashMap.put("BloodGroup", obj.optString("blood_group", "N/A"));
                            hashMap.put("Amount", obj.optString("amount", "N/A"));
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